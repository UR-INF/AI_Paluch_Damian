<?php include 'administratorzy.php' ?>


<?php
    $id = 0;
$update=false;

require_once "polaczenie.php";
$conn = oci_connect($login, $haslo, $host);
if (!$conn) {
    $m = oci_error();
    echo $m['message'];
    exit;
}
?>


<div class="container">
    <div class="row-justify-content-center">
        <div class="scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Nr. telefonu</th>
                        <th>Adres</th>
                        <th colspan="2">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select * from pracownicy where id_uzytkownika = 1";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);

                    while ($row = oci_fetch_array($stid)):
                    ?>
                    <tr>
                        <td><?php echo $row['IMIE'];?></td>
                        <td><?php echo $row['NAZWISKO'];?></td>
                        <td><?php echo $row['NR_TEL'];?></td>
                        <td><?php echo $row['ADRES'];?></td>



                        <td>
                            <form method="POST">
                                <input type="submit" name="edytuj" class="btn btn-outline-info" value="Edytuj">

                                <input type="hidden" value="<?php echo $row['ID']; ?>" name="id"/>
                            </form>


                    </tr>

                    <?php endwhile; ?>



                </tbody>
            </table>
        </div>
    </div>

    <?php
    if(isset($_POST['edytuj'])){       
        $id = $_POST['id'];
        $update = true;
        $query = "select * from pracownicy where id = '$id' and id_uzytkownika = 1";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);

        $row =oci_fetch_array($stid);
        $imie = $row['IMIE'];
        $nazwisko = $row['NAZWISKO'];
        $nrTel = $row['NR_TEL'];
        $adres = $row['ADRES'];
        $id = $row['ID'];
    }
    ?>
    <?php if ($update == true):?>
    <div id="srodek">

        <form method="POST">
            <div class="row justify-content-center">
                <div class="form-group">
                    <input name="imie" value="<?php echo $imie;?>" type="text" placeholder="Imię" class="form-control" required="">
                </div>
                <div class="form-group">
                    <input name="nazwisko" value="<?php echo $nazwisko;?>" type="text" placeholder="Nazwisko" class="form-control" required="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group">
                    <input name="nrTel" value="<?php echo $nrTel;?>" type="number" placeholder="Nr. telefonu" class="form-control" required="">
                </div>
                <div class="form-group">                   
                    <input class="form-control" name="adres" value="<?php echo $adres;?>" placeholder="Adres" required="">
                    <input type="hidden" value="<?php echo $id;?>" name="id"/>
                </div>
            </div>
                <div class="form-group"> 
                
                <div class="row justify-content-center">
                    <button name="zapisz" class="btn btn-secondary">Zapisz</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif;?>




<?php
if(isset($_POST['zapisz'])){
    $query = "begin edytuj_dane.edytuj_pracownikow(:id, :imie, :nazwisko, :nrTel, :adres); end;";
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $nrTel = $_POST['nrTel'];
    $adres = $_POST['adres'];
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":id", $id);
    oci_bind_by_name($stid, ":imie", $imie);
    oci_bind_by_name($stid, ":nazwisko", $nazwisko);
    oci_bind_by_name($stid, ":nrTel", $nrTel);
    oci_bind_by_name($stid, ":adres", $adres);
    $result = oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");


}
?>


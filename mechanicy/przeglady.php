<?php include 'mechanicy.php' ?>

<?php
    $id = 0;
$update=false;
$samochod='';
$uwagi_klienta='';
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
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Data</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select p.*, s.marka, s.model
                    from przeglady p, samochody s
                    where p.id_samochodu = s.id
                    and p.id_mechanika is null";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);

                    while ($row = oci_fetch_array($stid)):
                    ?>
                    <tr>
                        <td><?php echo $row['MARKA'];?></td>
                        <td><?php echo $row['MODEL'];?></td>
                        <td><?php echo $row['DATA'];?></td>

                        <td>
                            <form method="POST">
                                <input type="submit" name="obsluz" class="btn btn-outline-info" value="Obsłuż">

                                <input type="hidden" value="<?php echo $row['ID']; ?>" name="id"/>
                            </form>


                    </tr>

                    <?php endwhile; ?>



                </tbody>
            </table>
        </div>
    </div>

    <?php
    if(isset($_POST['obsluz'])){       
        $id = $_POST['id'];
        $update = true;
        $query = "select p.*, s.marka, s.model from przeglady p, samochody s where p.id_samochodu = s.id and p.id = '$id'";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);

        $row =oci_fetch_array($stid);
        $samochod = $row['MARKA'] . ' ' . $row['MODEL'];

        $id = $row['ID'];
    }
    ?>
    <?php if ($update == true):?>
    <div id="srodek">

        <form method="POST">
            <div class="row justify-content-center">
                <div class="form-group">
                    <input name="samochod" value="<?php echo $samochod;?>" type="text"  class="form-control" readonly>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="form-group">
                    <center><label for="dataWaznosci">Data ważności</label></center>
                    <input name="dataWaznosci" type="date"  class="form-control" >
                </div>&nbsp;
                <div class="form-group"> 
                    <center><label for="uwagi">Uwagi</label></center>
                    <input name="uwagi" type="text" class="form-control" id="bdlugie">
                </div>
            </div>
                <div class="row justify-content-center">
                    <div class="form-group">   

                        <input type="radio" id="pozytywny" name="wynik" value="Pozytywny">
                        <label for="pozytywny">Pozytywny</label>
                        <input type="radio" id="negatywny" name="wynik" value="Negatywny">
                        <label for="negatywny">Negatywny</label>
                    </div>
                </div>

                <div class="form-group">   
                    <input type="hidden" value="<?php echo $id;?>" name="id"/>
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
    $query = "begin obsluz_dane.obsluz_przeglad(:id, :data, :idMechanika, :wynik, :uwagi); end;";
    $id = $_POST['id'];
    $data = $_POST['dataWaznosci'];
    $wynik = $_POST['wynik'];
    $uwagi = $_POST['uwagi'];
    $idMechanika = 1;
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":id", $id);
    oci_bind_by_name($stid, ":data", $data);
    oci_bind_by_name($stid, ":idMechanika", $idMechanika);
    oci_bind_by_name($stid, ":wynik", $wynik);
    oci_bind_by_name($stid, ":uwagi", $uwagi);
    $result = oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");


}
?>


<?php include 'mechanicy.php' ?>

<?php
    $idMechanika = $_SESSION['id'];
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
                        <th>Usługa</th>
                        <th>Data</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select su.*, s.marka, s.model, u.nazwa
                    from samochody_uslugi su, samochody s, uslugi u
                    where su.id_samochodu = s.id and su.id_uslugi = u.id
                    and su.id_mechanika is NULL";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);

                    while ($row = oci_fetch_array($stid)):
                    ?>
                    <tr>
                        <td><?php echo $row['MARKA'];?></td>
                        <td><?php echo $row['MODEL'];?></td>
                        <td><?php echo $row['NAZWA'];?></td>
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
        $query = "select su.*, s.marka, s.model, u.nazwa from samochody_uslugi su, samochody s, uslugi u where su.id_samochodu = s.id and su.id_uslugi = u.id and su.id = '$id'";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);

        $row =oci_fetch_array($stid);
        $samochod = $row['MARKA'] . ' ' . $row['MODEL'];
        $usluga = $row['NAZWA'];
        $id = $row['ID'];
    }
    ?>
    <?php if ($update == true):?>
    <div id="srodek">

        <form method="POST">
            <div class="row justify-content-center">
                <div class="form-group">
                    <input name="samochod" value="<?php echo $samochod;?>" type="text"  class="form-control" readonly>
                </div>&nbsp;
                <div class="form-group">
                    <input name="usluga" value="<?php echo $usluga;?>" type="text"  class="form-control" readonly>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="form-group">                   
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
    $query = "begin obsluz_dane.obsluz_usluge(:id, :idMechanika); end;";
    $id = $_POST['id'];
    $idMechanika;
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":id", $id);
    oci_bind_by_name($stid, ":idMechanika", $idMechanika);
    $result = oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");


}
?>


<?php include 'klienci.php' ?>
<div class="d-flex justify-content-center">
    <div class="card">
        <?php
    require_once "polaczenie.php";
$conn = oci_connect($login, $haslo, $host);
if(!$conn)
{
    $m = oci_error();
    echo $m['message'], "\n";
    exit;   
}
$id = 1;
$query="select * from samochody where id_klienta = '$id'";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
        ?>
        <form method="post">
            <div class="form-group">
                <select name="idSamochodu">
                    <?php
                    while($row=oci_fetch_array($stid)):?>
                    <option value="<?php echo $row['ID'];?>"><?php echo $row['MARKA'] . ' ' . $row['MODEL'];?> 

                    </option>

                    <?php endwhile;?>
                </select>
                <div class="float-right">
                    <button class="btn btn-secondary" type="submit" name="edytujDane">Edytuj dane</button>
                </div>
            </div>
            <button class="btn btn-secondary" type="submit" name="edytujSamochod">Edytuj samochód</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edytujSamochod'])):
        $idSamochodu = $_POST['idSamochodu'];

        $query="select * from samochody where id = '$idSamochodu'";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);
        while($row=oci_fetch_array($stid)):
        ?>
        <form method="post">

            <div class="form-group">
                <input type="text" name="marka" class="form-control" value="<?php echo $row['MARKA']?>" placeholder="Marka" required="">
            </div>
            <div class="form-group">
                <input type="text" name="model" class="form-control" value="<?php echo $row['MODEL']?>" placeholder="Model"  required="">
            </div>
            <div class="form-group">
                <input type="number" name="pojSilnika" class="form-control" value="<?php echo $row['POJ_SILNIKA']?>" placeholder="Pojemność silnika" required="">
            </div>
            <div class="form-group">
                <input type="number" name="rok" class="form-control" value="<?php echo $row['ROK']?>" placeholder="Rok" required="">
            </div>
            <input type="hidden" name="idSamochodu" value="<?php echo $row['ID'];?>">
            <button class="btn btn-secondary" type="submit" name="zapiszSamochod">Zapisz</button>
        </form>

        <?php endwhile;endif;

        
        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edytujDane'])):
        $idKlienta = 1;

        $query="select * from klienci where id = '$idKlienta'";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);
        while($row=oci_fetch_array($stid)):
        ?>
        <form method="post">

            <div class="form-group">
                <input type="text" name="imie" class="form-control" value="<?php echo $row['IMIE']?>" placeholder="Imię" required="">
            </div>
            <div class="form-group">
                <input type="text" name="nazwisko" class="form-control" value="<?php echo $row['NAZWISKO']?>" placeholder="Nazwisko"  required="">
            </div>
            <div class="form-group">
                <input type="number" name="nrTel" class="form-control" value="<?php echo $row['NR_TEL']?>" placeholder="Numer telefonu" required="">
            </div>
            
            <button class="btn btn-secondary" type="submit" name="zapiszDane">Zapisz</button>
        </form>

        <?php endwhile;endif;  ?>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['zapiszSamochod'])) {

    $query = "begin edytuj_dane.edytuj_samochod(:idSamochodu, :marka, :model, :pojSilnika, :rok); end;";
    $idSamochodu = $_POST['idSamochodu'];
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $pojSilnika = $_POST['pojSilnika'];
    $rok = $_POST['rok'];
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":idSamochodu", $idSamochodu);
    oci_bind_by_name($stid, ":marka", $marka);
    oci_bind_by_name($stid, ":model", $model);
    oci_bind_by_name($stid, ":pojSilnika", $pojSilnika);
    oci_bind_by_name($stid, ":rok", $rok);
    $result = oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");

}

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['zapiszDane'])) {

    $query = "begin edytuj_dane.edytuj_dane_klienta(:idKlienta, :imie, :nazwisko, :nrTel); end;";
    $idKlienta = 1;
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $nrTel = $_POST['nrTel'];
    $stid = oci_parse($conn, $query);
    
    oci_bind_by_name($stid, ":idKlienta", $idKlienta);
    oci_bind_by_name($stid, ":imie", $imie);
    oci_bind_by_name($stid, ":nazwisko", $nazwisko);
    oci_bind_by_name($stid, ":nrTel", $nrTel);
    $result = oci_execute($stid);


}
?>
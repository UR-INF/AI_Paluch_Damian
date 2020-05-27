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
$id = $_SESSION['id'];
$query="select * from samochody where id_klienta = '$id'";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);
        ?>
        <form method="post">
            <div class="form-group">
                <select name="id">
                    <?php
                    while($row=oci_fetch_array($stid)):?>
                    <option value="<?php echo $row['ID'];?>"><?php echo $row['MARKA'] . ' ' . $row['MODEL'];?> 

                    </option>

                    <?php endwhile;?>
                </select>
            </div>

            <div class="form-group">
                <input name="data" type="date" class="form-control" required>
            </div>
            <button class="btn btn-secondary" type="submit" name="przeglad">Dodaj</button>
        </form>


        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['przeglad'])) {
            error_reporting(E_ALL ^ E_WARNING);
            $query = "begin dodaj_dane.dodaj_przeglad(:idSamochodu, :data); end;";

            $idSamochodu = $_POST['id'];
            $data = $_POST['data'];
            $stid = oci_parse($conn, $query);

            oci_bind_by_name($stid, ":idSamochodu", $idSamochodu);
            oci_bind_by_name($stid, ":data", $data);
            $result = oci_execute($stid);
            if(false === $result){
                $e = oci_error($stid);
                if($e['code'] == 20006)
                {?>
        <div class="alert alert-dismissible alert-secondary">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Błąd</strong> Podałeś date z przeszłości
        </div> <?php
                }else if($e['code'] == 20007)
                {?>
        <div class="alert alert-dismissible alert-secondary">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Błąd</strong> Nie pracujemy w weekendy
        </div> <?php
                }
            }
        }
        ?>
    </div>
</div>
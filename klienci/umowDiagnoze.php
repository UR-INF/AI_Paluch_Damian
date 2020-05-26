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
                <select name="id">
                    <?php
                    while($row=oci_fetch_array($stid)):?>
                    <option value="<?php echo $row['ID'];?>"><?php echo $row['MARKA'] . ' ' . $row['MODEL'];?> 

                    </option>

                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <input name="uwagi" type="text" placeholder="Uwagi" class="form-control">
            </div>
            <div class="form-group">
                <input name="data" type="date" class="form-control" required>
            </div>
            <button class="btn btn-secondary" type="submit" name="diagnoza">Dodaj</button>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['diagnoza'])) {

    $query = "begin dodaj_dane.dodaj_diagnoze(:idSamochodu, :uwagi, :data); end;";

    $idSamochodu = $_POST['id'];
    $uwagi = $_POST['uwagi'];
    $data = $_POST['data'];
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":idSamochodu", $idSamochodu);
    oci_bind_by_name($stid, ":uwagi", $uwagi);
    oci_bind_by_name($stid, ":data", $data);
    $result = oci_execute($stid);



}
?>
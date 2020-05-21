<?php include 'klienci.php' ?>
klient dodaj samochód
<form method="post">
    <div class="form-group">
        <label class="col-form-label" for="inputDefault">Default input</label>
        <input type="text" name="marka" class="form-control" placeholder="Marka" id="marka" required="">
    </div>
    <div class="form-group">
        <label class="col-form-label" for="inputDefault">Default input</label>
        <input type="text" name="model" class="form-control" placeholder="Default input" id="model" required="">
    </div>
    <div class="form-group">
        <label class="col-form-label" for="inputDefault">Default input</label>
        <input type="number" name="pojSilnika" class="form-control" placeholder="Default input" id="pojSilnika" required="">
    </div>
    <div class="form-group">
        <label class="col-form-label" for="inputDefault">Default input</label>
        <input type="number" name="rok" class="form-control" placeholder="Default input" id="rok" required="">
    </div>
    <button class="btn btn-secondary" type="submit" name="dodajSamochod">Dodaj</button>
</form>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dodajSamochod']))
    {
        try
        {
            require_once "polaczenie.php";
            $conn = oci_connect($login, $haslo, $host);
            if(!$conn)
            {
                $m = oci_error();
                echo $m['message'], "\n";
                exit;   
            }
            $query="begin dodaj_dane.dodaj_samochod(:marka, :model, :pojSilnika, :rok, :id); end;";

            $marka = $_POST['marka'];
            $model = $_POST['model'];
            $pojSilnika = $_POST['pojSilnika'];
            $rok = $_POST['rok'];
            $id = 1;
            $stid = oci_parse($conn, $query);

            oci_bind_by_name($stid, ":marka",  $marka);
            oci_bind_by_name($stid, ":model", $model);
            oci_bind_by_name($stid, ":pojSilnika",  $pojSilnika);
            oci_bind_by_name($stid, ":rok", $rok);
            oci_bind_by_name($stid, ":id", $id);
            $result = oci_execute($stid);

        }
        catch(Exception $error)
        {
            echo 'Błąd serwera!';
        }
    }
?>
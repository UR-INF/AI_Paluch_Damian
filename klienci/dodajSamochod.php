<?php include 'klienci.php';
$idKlienta = $_SESSION['id'];?>
<div class="d-flex justify-content-center">
    <div class="card">
        <form method="post">
            <div class="form-group">
                <input type="text" name="marka" class="form-control" placeholder="Marka"  required="">
            </div>
            <div class="form-group">
                <input type="text" name="model" class="form-control" placeholder="Model" required="">
            </div>
            <div class="form-group">

                <input type="number" name="pojSilnika" class="form-control" placeholder="Pojemność silnika" required="">
            </div>
            <div class="form-group">
                <input type="number" name="rok" class="form-control" placeholder="Rok produkcji"  required="">
            </div>
            <center>
                <button class="btn btn-secondary" type="submit" name="dodajSamochod">Dodaj</button>
            </center>
        </form>
    </div>
</div>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dodajSamochod']))
{
    require_once "polaczenie.php";
    $conn = oci_connect($login, $haslo, $host);
    if(!$conn)
    {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;   
    }
    error_reporting(E_ALL ^ E_WARNING);
    $query = "begin czy_mozna.czy_mozna_samochod(:marka, :model, :id); end;";

    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":marka", $marka);
    oci_bind_by_name($stid, ":model", $model);
    oci_bind_by_name($stid, ":id", $idKlienta);

    oci_execute($stid);

    $e = oci_error($stid);
    if($e['code'] == 20008)
    {?>
<div class="d-flex justify-content-center">
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd</strong> Podany samochód już istnieje
    </div>
</div><?php
    }else{


        $query="begin dodaj_dane.dodaj_samochod(:marka, :model, :pojSilnika, :rok, :id); end;";

        $marka = $_POST['marka'];
        $model = $_POST['model'];
        $pojSilnika = $_POST['pojSilnika'];
        $rok = $_POST['rok'];
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":marka",  $marka);
        oci_bind_by_name($stid, ":model", $model);
        oci_bind_by_name($stid, ":pojSilnika",  $pojSilnika);
        oci_bind_by_name($stid, ":rok", $rok);
        oci_bind_by_name($stid, ":id", $idKlienta);
        $result = oci_execute($stid);
    }
}
?>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 2000);
</script>

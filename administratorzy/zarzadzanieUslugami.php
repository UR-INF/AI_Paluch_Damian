<?php include 'administratorzy.php' ?>


<?php
    $id = 0;
$update=false;
$nazwa='';
$opis='';
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
                        <th>Nazwa</th>
                        <th>Opis</th>
                        <th colspan="2">Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "select * from uslugi";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);

                    while ($row = oci_fetch_array($stid)):
                    ?>
                    <tr>
                        <td><?php echo $row['NAZWA'];?></td>
                        <td><?php echo $row['OPIS'];?></td>

                        

                        <td>
                            <form method="POST">
                                <input type="submit" name="edytuj" class="btn btn-outline-info" value="Edytuj">

                                <input type="submit" name="usun" class="btn btn-outline-danger" value="Usun">
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
        $query = "select * from uslugi where id = '$id'";
        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);

        $row =oci_fetch_array($stid);
        $nazwa = $row['NAZWA'];
        $opis = $row['OPIS'];
        $id = $row['ID'];
    }
    ?>
    <div id="srodek">
        <div class="row justify-content-center">
            <form method="POST">
                <div class="form-group">
                    <input name="nazwa" value="<?php echo $nazwa;?>" type="text" placeholder="nazwa" class="form-control" required="">
                </div>
                <div class="form-group">                   
                    <input class="form-control" name="opis" value="<?php echo $opis;?>" id="opis" placeholder="opis" required="">
                    <input type="hidden" value="<?php echo $id;?>" name="id"/>
                </div>
                <div class="form-group"> 
                    <?php
                    if ($update == true):
                    ?>
                    <button name="zapisz" class="btn btn-secondary">Zapisz</button>  
                    <?php else: ?>
                    <button name="dodajUsluge" class="btn btn-secondary">Dodaj</button>             <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dodajUsluge'])) {
    try {
        $conn = oci_connect($login, $haslo, $host);
        if (!$conn) {
            $m = oci_error();
            echo $m['message'], "\n";
            exit;
        }
        $query = "begin dodaj_dane.dodaj_usluge_admin(:nazwa, :opis); end;";

        $nazwa = $_POST['nazwa'];
        $opis = $_POST['opis'];
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":nazwa", $nazwa);
        oci_bind_by_name($stid, ":opis", $opis);
        $result = oci_execute($stid);

        echo("<meta http-equiv='refresh' content='0'>");
    } catch (Exception $error) {
        echo 'Blad serwera!';
    }
}

if(isset($_POST['usun'])){
    $id = $_POST['id'];
    $query = "delete from uslugi where id = '$id'";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");

}
if(isset($_POST['zapisz'])){
    $query = "begin edytuj_dane.edytuj_uslugi(:id, :nazwa, :opis); end;";
    $id = $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":id", $id);
    oci_bind_by_name($stid, ":nazwa", $nazwa);
    oci_bind_by_name($stid, ":opis", $opis);
    $result = oci_execute($stid);

    echo("<meta http-equiv='refresh' content='0'>");


}
?>


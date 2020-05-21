<?php include 'administratorzy.php' ?>
administrator zarzadzanie uslugami

<table class="table table-hover">
    <tbody>
        <tr class="table-active">
            <th scope="row">Nazwa</th>
            <td>Opis</td>
        </tr>
    </tbody>
    <?php
    require_once "polaczenie.php";
$conn = oci_connect($login, $haslo, $host);
if(!$conn)
{
    $m = oci_error();
    echo $m['message'], "\n";
    exit;   
}
$query="select * from uslugi";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

while($row=oci_fetch_array($stid))

{
    echo "<tr><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>";
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['szukaj']))
{
    try
    {
        $conn = oci_connect($login, $haslo, $host);
        if(!$conn)
        {
            $m = oci_error();
            echo $m['message'], "\n";
            exit;   
        }
        $query="begin szukaj_danych.szukaj_edycji_uslugi_admin(:szukane, :cursor); end;";

        $szukane = $_POST['szukajField'];
        $curs = oci_new_cursor($conn);
        $stid = oci_parse($conn, $query);

        oci_bind_by_name($stid, ":szukane",  $szukane);
        oci_bind_by_name($stid, ":cursor", $curs, -1, OCI_B_CURSOR);
        $result = oci_execute($stid);
        oci_execute($curs);

        while($row = oci_fetch_assoc($curs))

        {
            echo "<tr><td>" . $row['NAZWA'] . "</td><td>" . $row['OPIS'] . "</td></tr>";
        }

    }
    catch(Exception $error)
    {
        echo 'Błąd serwera!';
    }
}
echo "</table>";
    ?>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="szukajField" class="form-control input-md" placeholder="Szukana wartość">
        </div>
        <button class="btn btn-secondary" type="submit" name="szukaj">Szukaj</button>
    </form>
    <form method="POST">
        <div class="form-group">
            <div class="col-4">
                <input id="nazwa" name="nazwa" type="text" placeholder="nazwa" class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <div class="col-4">                     
                <textarea class="form-control" name="opis" id="opis" placeholder="opis" name="opis" required=""></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-4">
                <button id="dodajUsluge" name="dodajUsluge" class="btn btn-primary">Dodaj</button>
            </div>
        </div>
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dodajUsluge']))
    {
        try
        {
            $conn = oci_connect($login, $haslo, $host);
            if(!$conn)
            {
                $m = oci_error();
                echo $m['message'], "\n";
                exit;   
            }
            $query="begin dodaj_dane.dodaj_usluge_admin(:nazwa, :opis); end;";

            $nazwa = $_POST['nazwa'];
            $opis = $_POST['opis'];
            $stid = oci_parse($conn, $query);

            oci_bind_by_name($stid, ":nazwa",  $nazwa);
            oci_bind_by_name($stid, ":opis", $opis);
            $result = oci_execute($stid);

        }
        catch(Exception $error)
        {
            echo 'Błąd serwera!';
        }
    }
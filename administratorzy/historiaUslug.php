<?php include 'administratorzy.php' ?>
administrator historia uslug

<table class="table table-hover">
    <tbody>
        <tr class="table-active">
            <th scope="row">Marka</th>
            <td>Model</td>
            <td>Usługa</td>
            <td>Data</td>
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
$query="select s.marka, s.model, u.nazwa, su.data
from samochody s, samochody_uslugi su, uslugi u
where s.id = su.id_samochodu
and su.id_uslugi = u.id";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

while($row=oci_fetch_array($stid))

{
    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
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
            $query="begin szukaj_danych.szukaj_uslugi_admin(:szukane, :cursor); end;";

            $szukane = $_POST['szukajField'];
            $curs = oci_new_cursor($conn);
            $stid = oci_parse($conn, $query);
            
            oci_bind_by_name($stid, ":szukane",  $szukane);
            oci_bind_by_name($stid, ":cursor", $curs, -1, OCI_B_CURSOR);
            $result = oci_execute($stid);
            oci_execute($curs);
            
            while($row = oci_fetch_assoc($curs))

            {
    echo "<tr><td>" . $row['MARKA'] . "</td><td>" . $row['MODEL'] . "</td><td>" . $row['NAZWA'] . "</td><td>" . $row['DATA'] . "</td></tr>";
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
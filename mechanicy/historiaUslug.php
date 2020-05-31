<?php include 'mechanicy.php' ?>
<?php $id = $_SESSION['id'];?>
<div class="container">
    
    <div class="table-wrapper-scroll-y">
        <br><center><strong>Usługi</strong></center>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Marka</th>
                    <th scope="col">Model</th>
                    <th scope="col">Usługa</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
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
and su.id_uslugi = u.id
and su.id_mechanika = '$id'";
                $stid = oci_parse($conn, $query);
                $result = oci_execute($stid);

                while($row=oci_fetch_array($stid))

                {
                    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
                }
                if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['szukajU']))
                {
                ?>
                <script type="text/javascript">
                    var tableHeaderRowCount = 1;
                    var table = document.getElementById('myTable');
                    var rowCount = table.rows.length;
                    for (var i = tableHeaderRowCount; i < rowCount; i++) {
                        table.deleteRow(tableHeaderRowCount);
                    }
                </script>

                <?php

                    $conn = oci_connect($login, $haslo, $host);
                    if(!$conn)
                    {
                        $m = oci_error();
                        echo $m['message'], "\n";
                        exit;   
                    }

                    $query="begin szukaj_danych.szukaj_uslugi(:szukane, :id, :cursor); end;";

                    $szukane = $_POST['szukajUslugi'];
                    $curs = oci_new_cursor($conn);
                    $stid = oci_parse($conn, $query);

                    oci_bind_by_name($stid, ":szukane",  $szukane);
                    oci_bind_by_name($stid, ":id",  $id);
                    oci_bind_by_name($stid, ":cursor", $curs, -1, OCI_B_CURSOR);
                    $result = oci_execute($stid);
                    oci_execute($curs);

                    while($row = oci_fetch_assoc($curs)):
                ?>

                <tr>

                    <td><?php echo $row['MARKA'];?></td>
                    <td><?php echo $row['MODEL'];?></td>
                    <td><?php echo $row['NAZWA'];?></td>
                    <td><?php echo $row['DATA'];?></td>
                </tr>
                <?php endwhile; 

                }

                ?>

            </tbody>

        </table>

        <div class="srodek">
            <form method="POST">
                <div class="row justify-content-center">
                    <div class="form-group">
                        <input type="text" name="szukajUslugi" class="form-control" placeholder="Szukana wartość">
                    </div>&nbsp;
                    <div class="form-group">
                        <button class="btn btn-secondary" type="submit" name="szukajU">Szukaj usługi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'administratorzy.php' ?>


<?php

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
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Wynik</th>
                        <th>Data ważności</th>
                        <th>Uwagi</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query="select s.marka, s.model, p.wynik, p.data_waznosci, p.uwagi, p.data
                    from samochody s, przeglady p where s.id = p.id_samochodu";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);

                    while ($row = oci_fetch_array($stid)):
                    ?>
                    <tr>
                        <td><?php echo $row['MARKA'];?></td>
                        <td><?php echo $row['MODEL'];?></td>
                        <td><?php echo $row['WYNIK'];?></td>
                        <td><?php echo $row['DATA_WAZNOSCI'];?></td>
                        <td><?php echo $row['UWAGI'];?></td>
                        <td><?php echo $row['DATA'];?></td>
                    </tr>

                    <?php endwhile; 

                    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['szukaj']))
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
                        $query="begin szukaj_danych.szukaj_przegladu_admin(:szukane, :cursor); end;";

                        $szukane = $_POST['szukajField'];
                        $curs = oci_new_cursor($conn);
                        $stid = oci_parse($conn, $query);

                        oci_bind_by_name($stid, ":szukane",  $szukane);
                        oci_bind_by_name($stid, ":cursor", $curs, -1, OCI_B_CURSOR);
                        $result = oci_execute($stid);
                        oci_execute($curs);

                        while($row = oci_fetch_assoc($curs)):
                    ?>
                    <tr>
                        <td><?php echo $row['MARKA'];?></td>
                        <td><?php echo $row['MODEL'];?></td>
                        <td><?php echo $row['WYNIK'];?></td>
                        <td><?php echo $row['DATA_WAZNOSCI'];?></td>
                        <td><?php echo $row['UWAGI'];?></td>
                        <td><?php echo $row['DATA'];?></td>
                    </tr>

                    <?php endwhile;


                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="srodek">
        <form method="POST">
            <div class="row justify-content-center">
                <div class="form-group">
                    <input type="text" name="szukajField" class="form-control" placeholder="Szukana wartość">
                </div>&nbsp;
                <div class="form-group">
                    <button class="btn btn-secondary" type="submit" name="szukaj">Szukaj</button>
                </div>
            </div>
        </form>
    </div>

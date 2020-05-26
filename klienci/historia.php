<?php include 'klienci.php' ?>

<div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Marka</th>
        <th scope="col">Model</th>
        <th scope="col">Uwagi</th>
        <th scope="col">Uwagi mechanika</th>
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
$query="select s.marka, s.model, d.uwagi_klienta, d.uwagi_mechanika, d.data
from samochody s, diagnozy d
where s.id = d.id_samochodu";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

while($row=oci_fetch_array($stid))

{
    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>";
}
?>
    </tbody>
  </table>

</div>

<div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table ">
    <thead>
      <tr>
        <th scope="col">Marka</th>
        <th scope="col">Model</th>
        <th scope="col">Wynik</th>
        <th scope="col">Ważność</th>
        <th scope="col">Uwagi</th>
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
$query="select s.marka, s.model, p.wynik, p.data_waznosci, p.uwagi, p.data
from samochody s, przeglady p
where s.id = p.id_samochodu";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

    while($row=oci_fetch_array($stid))

{
echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td></tr>";
}
?>
    </tbody>
  </table>

</div>

<div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table">
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
and su.id_uslugi = u.id";
$stid = oci_parse($conn, $query);
$result = oci_execute($stid);

while($row=oci_fetch_array($stid))

{
    echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
}
?>
    </tbody>
  </table>

</div>
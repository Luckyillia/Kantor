<?php
$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}
$date = date("Y-m-d");

$dane = file_get_contents('https://api.nbp.pl/api/exchangerates/rates/a/usd?format=json');
$json = json_decode($dane);
$kurs = $json->rates[0]->mid;

$sql = "INSERT INTO kurs(waluta_id,data,kurs) VALUES (1,'$date',$kurs)";
$conn->query($sql);

$dane = file_get_contents('https://api.nbp.pl/api/exchangerates/rates/a/eur?format=json');
$json = json_decode($dane);
$kurs = $json->rates[0]->mid;

$sql = "INSERT INTO kurs(waluta_id,data,kurs) VALUES (2,'$date',$kurs)";
$conn->query($sql);

$dane = file_get_contents('https://api.nbp.pl/api/exchangerates/rates/a/uah?format=json');
$json = json_decode($dane);
$kurs = $json->rates[0]->mid;

$sql = "INSERT INTO kurs(waluta_id,data,kurs) VALUES (3,'$date',$kurs)";
$conn->query($sql);

$dane = file_get_contents('https://api.nbp.pl/api/exchangerates/rates/a/cad?format=json');
$json = json_decode($dane);
$kurs = $json->rates[0]->mid;

$sql = "INSERT INTO kurs(waluta_id,data,kurs) VALUES (4,'$date',$kurs)";
$conn->query($sql);

$dane = file_get_contents('https://api.nbp.pl/api/exchangerates/rates/a/jpy?format=json');
$json = json_decode($dane);
$kurs = $json->rates[0]->mid;

$sql = "INSERT INTO kurs(waluta_id,data,kurs) VALUES (5,'$date',$kurs)";
$conn->query($sql);

$conn->close();
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
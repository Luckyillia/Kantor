<?php
$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}

$user_id = $_GET['id'];
for ($i = 1; $i <= 5; $i++) {
$query = "INSERT INTO portfel (user_id, waluta_id, amount) VALUES ($user_id,$i,0)";
$conn->query($query);
}
$conn->close();
header("Location: ".$_SERVER['HTTP_REFERER']);
?>

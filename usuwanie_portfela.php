<?php
$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}

$user_id = $_GET['id'];
$query = "DELETE FROM portfel WHERE user_id = $user_id";
$conn->query($query);
$query = "ALTER TABLE portfel AUTO_INCREMENT = 1";
$conn->query($query);
$conn->close();
header("Location: ".$_SERVER['HTTP_REFERER']);
?>

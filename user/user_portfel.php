<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'User') {
    header("Location: /kantor/log.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'];
if ($_POST) {
    $portfel = (float)$_POST['portfel'];

    $sql = "UPDATE users SET portfel=$portfel WHERE user_id = $user_id";
    $conn->query($sql);

    header("location: user.php");
}

$sql = "SELECT * FROM users WHERE user_id=$user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ustawienia portfela</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data" class="container">
        <?php
        echo "<h2>Ustawienia portfela dla<br> ID " . $_SESSION['user_id'] . "</h2>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); ?>
                <label>Portfel:</label>
                <input type="number" step="0.01" name="portfel" value="<?php echo $row['portfel']; ?>">
                <button type="submit">Zapisz</button>
        <?php } else {
            echo "Brak danych";
        } ?>
    </form>
</body>
</html>

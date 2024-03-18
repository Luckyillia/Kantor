<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'Admin') {
    header("Location: /kantor/log.php");
    exit();
}



$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}

if ($_POST) {
    $portfel = (float)$_POST['portfel'];

    $sql = "UPDATE users SET portfel=$portfel WHERE user_id=" . $_SESSION['user_id'];

    $conn->query($sql);
    header("location: user_admin.php");
}

$sql = "SELECT * FROM users WHERE user_id=" . $_SESSION['user_id'];
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <?php 
            echo "<h1>ID " . $_SESSION['user_id'] . "</h1>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); ?>
                <label>Portfel: </label><br>
                <input type="number" step="0.01" name="portfel" value="<?php echo $row['portfel']; ?>"></td>
                <button type="submit">Zapisz</button></td>
            <?php } else {
                echo "Nie ma nic";
            } ?>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>

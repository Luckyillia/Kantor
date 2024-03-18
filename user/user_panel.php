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
    $name = $_POST['imie'];
    $surname = $_POST['nazwisko'];
    $password = $_POST['haslo'];
    $login = $_POST['e_mail'];
    $_SESSION['imie'] = $name;
    $_SESSION['nazwisko'] = $surname;

    
    $sql = "UPDATE users SET imie='$name', nazwisko='$surname', login='$login', haslo='$password' WHERE user_id=$user_id";
    $conn->query($sql);


    header("location: user.php");
}
$sql = "SELECT * FROM users WHERE user_id=$user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil użytkownika</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data" class="container">
        <?php 
            echo "<h1>ID " . $_SESSION['user_id'] . "</h1>";
            if ($result) {
                $row = $result->fetch_assoc(); ?>
                <input type="text" name="imie" value="<?php echo $row['imie']; ?>"></td>
                <input type="text" name="nazwisko" value="<?php echo $row['nazwisko']; ?>"></td>
                <input type="text" name="e_mail" value="<?php echo $row['login']; ?>"></td>
                <input type="password" name="haslo" value="<?php echo $row['haslo']; ?>"></td>
                <button type="submit">Zapisz</button></td>
        <?php}else{
                echo "Brak danych";
            }?>
    </form>
</body>
</html>

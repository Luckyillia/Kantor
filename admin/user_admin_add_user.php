<?php
session_start();

if (!isset($_SESSION['type']) || $_SESSION['type'] != 'Admin') {
    header("Location: /kantor/log.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Użytkownika</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>

<body>

    <form method='POST' class="container">
        <label for="imie">Imię:</label><br>
        <input type='text' id="imie" name='imie' required><br>
        <label for="nazwisko">Nazwisko:</label><br>
        <input type='text' id="nazwisko" name='nazwisko' required><br>
        <label for="portfel">Portfel:</label><br>
        <input type='number' id="portfel" step='0.01' name='portfel' required><br>
        <label for="login">Login:</label><br>
        <input type='text' id="login" name='login' required><br>
        <label for="haslo">Hasło:</label><br>
        <input type='password' id="haslo" name='haslo' required><br>
        <label for="type">Typ:</label><br>
        <select id="type" name='type'>
            <option value='User'>User</option>
            <option value='Admin'>Admin</option>
        </select><br>
        <input type='submit' value='Zapisz'>
    </form>

</body>

</html>

<?php
if ($_POST) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['imie'];
    $surname = $_POST['nazwisko'];
    $portfel = (float)$_POST['portfel'];
    $haslo = $_POST['haslo'];
    $login = $_POST['login'];
    $type = $_POST['type'];
    $sql = "INSERT INTO users(imie, nazwisko, login, haslo, portfel, type) VALUES ('$name', '$surname', '$login', '$haslo', $portfel, '$type')";
    $conn->query($sql);
    header("location: user_admin_panel.php");
}
?>
    
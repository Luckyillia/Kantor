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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <form method='POST'>
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
    
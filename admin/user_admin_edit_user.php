<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'Admin') {
    header("Location: /kantor/log.php");
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
    <title>Edytuj Użytkownika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
        }
        table tr {
            margin-bottom: 10px;
        }
        table tr td {
            padding: 5px;
            text-align: left;
        }
        select {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
</head>

<body>

    <form method='POST'>
        <?php
        $sql = "SELECT * FROM users WHERE user_id=" . $_GET['id'];
        $result = $conn->query($sql);
        echo "<h1>ID " . $_GET['id'] . "</h1>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<table>";
            echo "<tr><td>Imie</td><td><input type='text' name='imie' value='" . $row['imie'] . "'></td></tr>";
            echo "<tr><td>Nazwisko</td><td><input type='text' name='nazwisko' value='" . $row['nazwisko'] . "'></td></tr>";
            echo "<tr><td>Portfel</td><td><input type= 'number' step='0.01' name='portfel' value='" . $row['portfel'] . "'></td></tr>";
            echo "<tr><td>Login</td><td><input type='text' name='e_mail' value='" . $row['login'] . "'></td></tr>";
            echo "<tr><td>Haslo</td><td><input type='password' name='haslo' value='" . $row['haslo'] . "'></td></tr>";
            echo "<tr><td>Type</td><td>
            <select name='type'>";
            if ($row['type'] == 'Admin') {
                echo "<option value='Admin'>Admin</option>
                     <option value='User'>User</option>";
            } else {
                echo "<option value='User'>User</option>
                     <option value='Admin'>Admin</option>";
            }
            "</select></td></tr>";
            echo "<tr><td colspan='2'><button type='submit'>Zapisz</button></td></tr>";
            echo "</table>";
        } else {
            echo "Nie ma nic";
        }
        ?>
    </form>

</body>

</html>

<?php
if ($_POST) {
    $name = $_POST['imie'];
    $surname = $_POST['nazwisko'];
    $portfel = (float)$_POST['portfel'];
    $haslo = $_POST['haslo'];
    $login = $_POST['e_mail'];
    $type = $_POST['type'];

    $sql = "UPDATE users SET imie='$name', nazwisko='$surname', login='$login', haslo='$haslo',portfel=$portfel, type='$type' WHERE user_id=" . $_GET['id'];

    $conn->query($sql);
    header("location: user_admin_panel.php");
}
$conn->close();
?>

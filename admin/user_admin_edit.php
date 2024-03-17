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
    $name = $_POST['imie'];
    $surname = $_POST['nazwisko'];
    $haslo = $_POST['haslo'];
    $login = $_POST['e_mail'];
    $type = $_POST['type'];
    $_SESSION['imie'] = $name;
    $_SESSION['nazwisko'] = $surname;

    $sql = "UPDATE users SET imie='$name', nazwisko='$surname', login='$login', haslo='$haslo',type='$type' WHERE user_id=" . $_SESSION['user_id'];

    $conn->query($sql);
    $_SESSION['type'] = $type;
    header("location: user_admin.php");
}

$sql = "SELECT * FROM users WHERE user_id=" . $_SESSION['user_id'];
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
    <form method="POST" enctype="multipart/form-data">
        <?php
        echo "<h1>ID " . $_SESSION['user_id'] . "</h1>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<table>";
            echo "<tr><td>Imie</td><td><input type='text' name='imie' value='" . $row['imie'] . "'></td></tr>";
            echo "<tr><td>Nazwisko</td><td><input type='text' name='nazwisko' value='" . $row['nazwisko'] . "'></td></tr>";
            echo "<tr><td>Login</td><td><input type='text' name='e_mail' value='" . $row['login'] . "'></td></tr>";
            echo "<tr><td>Haslo</td><td><input type='password' name='haslo' value='" . $row['haslo'] . "'></td></tr>";
            echo "<tr><td>Rola</td><td>
                    <select name='type'>";
            if ($row['type'] == 'Admin') {
                echo "<option value='Admin'>Admin</option>
                      <option value='User'>User</option>";
            } else {
                echo "<option value='User'>User</option>
                      <option value='Admin'>Admin</option>";
            }
            echo "</select>
                  </td></tr>";
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
$conn->close();
?>

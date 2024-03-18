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
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <form method="POST" enctype="multipart/form-data" class="container">
        <?php
        echo "<h1>ID " . $_SESSION['user_id'] . "</h1>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); ?>
            <label for="login">Imię:</label><br>
            <input type="text" name="imie" value="<?php echo $row['imie']; ?>"><br>
            <label for="login">Nazwisko:</label><br>
            <input type="text" name="nazwisko" value="<?php echo $row['nazwisko']; ?>"><br>
            <label for="login">Login:</label><br>
            <input type="text" name="e_mail" value="<?php echo $row['login']; ?>"><br>
            <label for="login">Hasło:</label><br>
            <input type="password" name="haslo" value="<?php echo $row['haslo']; ?>"><br>
            <select name='type'>
            <?php
            if ($row['type'] == 'Admin') {
                echo "<option value='Admin'>Admin</option>
                      <option value='User'>User</option>";
            } else {
                echo "<option value='User'>User</option>
                      <option value='Admin'>Admin</option>";
            }?>
            </select>
            <button type="submit">Zapisz</button>
        <?php } else {
            echo "Nie ma nic";
        }
        ?>
    </form>
</body>
</html>

<?php
$conn->close();
?>

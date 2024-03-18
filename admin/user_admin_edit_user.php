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
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>

<body>

    <form method='POST' class="container">
    <?php
    $sql = "SELECT * FROM users WHERE user_id=" . $_GET['id'];
    $result = $conn->query($sql);
    echo "<h1>ID " . $_GET['id'] . "</h1>";
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <label for="imie">Imię:</label>
        <input type='text' name='imie' id="imie" value='<?php echo $row['imie']; ?>'>

        <label for="nazwisko">Nazwisko:</label>
        <input type='text' name='nazwisko' id="nazwisko" value='<?php echo $row['nazwisko']; ?>'>

        <label for="portfel">Portfel:</label>
        <input type='number' step='0.01' name='portfel' id="portfel" value='<?php echo $row['portfel']; ?>'>

        <label for="e_mail">Login:</label>
        <input type='text' name='e_mail' id="e_mail" value='<?php echo $row['login']; ?>'>

        <label for="haslo">Hasło:</label>
        <input type='password' name='haslo' id="haslo" value='<?php echo $row['haslo']; ?>'>

        <label for="type">Type:</label>
        <select name='type' id="type">
            <?php
            if ($row['type'] == 'Admin') {
                echo "<option value='Admin'>Admin</option>
                     <option value='User'>User</option>";
            } else {
                echo "<option value='User'>User</option>
                     <option value='Admin'>Admin</option>";
            }
            ?>
        </select>

        <button type='submit'>Zapisz</button>
    <?php
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

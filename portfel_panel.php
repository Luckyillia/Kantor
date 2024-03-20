<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'kantor');
if ($conn->connect_error) {
    die("Blad Polaczenia: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT portfel.id, portfel.amount, waluta.name FROM portfel INNER JOIN waluta ON portfel.waluta_id = waluta.id WHERE portfel.user_id = " . $user_id;
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>

<body>
    <?php
    if ($result->num_rows > 0) {
    ?>

        <table class="container">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Waluta</th>
                    <th>Ilosc</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "</tr>";
                }
                ?>

                <tr >
                    <td colspan="9" class="kreseczka">
                        <div class="user-actions"><a href="<?php echo ($_SESSION['type'] == "Admin") ? '/kantor/admin/user_admin.php' : '/kantor/user/user.php'; ?>" class="link">Powrót</a></div>
                    </td>
                </tr>

            </tbody>
        </table>

    <?php
    } else {?>
        <div class='container'>
            <h1>Nie ma nic</h1>
            <div class='user-actions'>
                <a href="<?php echo ($_SESSION['type'] == "Admin") ? '/kantor/admin/user_admin.php' : '/kantor/user/user.php'; ?>" class="link">Powrót</a>
            </div>
        </div>
    <?php
    }
    ?>

</body>

</html>
<?php
$conn->close();
?>

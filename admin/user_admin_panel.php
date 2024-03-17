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
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .add-user-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-user-link:hover {
            background-color: #0056b3;
        }

        .wallet-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            float: right;
        }

        .wallet-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <?php
    if ($result->num_rows > 0) {
    ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imie</th>
                    <th>Nazwisko</th>
                    <th>Login</th>
                    <th>Haslo</th>
                    <th>Portfel</th>
                    <th>Type</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($row = $result->fetch_assoc()) {
                    if ($row['user_id'] == $_SESSION['user_id']) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['imie'] . "</td>";
                        echo "<td>" . $row['nazwisko'] . "</td>";
                        echo "<td>" . $row['login'] . "</td>";
                        echo "<td>" . $row['haslo'] . "</td>";
                        echo "<td>" . $row['portfel'] . "</td>";
                        echo "<td>" . $row['type'] . "</td></tr>";
                    } else {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['imie'] . "</td>";
                        echo "<td>" . $row['nazwisko'] . "</td>";
                        echo "<td>" . $row['login'] . "</td>";
                        echo "<td>" . $row['haslo'] . "</td>";
                        echo "<td>" . $row['portfel'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td><a href='user_admin_edit_user.php?id=" . $row['user_id'] . "'>Edytuj</a></td>";
                        echo "<td><a href='user_admin_drop_user.php?id=" . $row['user_id'] . "'>Usun</a></td>";
                        echo "</tr>";
                    }
                }
                ?>

                <tr>
                    <td colspan="9">
                        <a href='user_admin_add_user.php' class='add-user-link'>Dodaj nowego uzytkownika</a>
                        <a href='user_admin.php' class='wallet-link'>Stan Portfela</a>
                    </td>
                </tr>

            </tbody>
        </table>

    <?php
    } else {
        echo "Nie ma nic";
        echo "<a href='user_admin_add_user.php' class='add-user-link'>Dodaj nowego uzytkownika</a>";
        echo "<a href='user_admin.php' class='wallet-link'>Stan Portfela</a>";
    }
    ?>

</body>

</html>
<?php
$conn->close();
?>

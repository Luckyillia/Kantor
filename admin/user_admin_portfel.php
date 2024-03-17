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
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            margin: 0 auto;
            text-align: left;
        }
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <?php 
            echo "<h1>ID " . $_SESSION['user_id'] . "</h1>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc(); ?>
                <table>
                    <tr>
                        <td>Portfel</td>
                        <td><input type="number" step="0.01" name="portfel" value="<?php echo $row['portfel']; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Zapisz</button></td>
                    </tr>
                </table>
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
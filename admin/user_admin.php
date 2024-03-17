<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'Admin') {
    header("Location: /kantor/log.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kantor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT portfel FROM users WHERE user_id = $user_id";
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
        .info {
            margin-bottom: 10px;
        }
        .link {
            display: block;
            margin-bottom: 5px;
            text-decoration: none;
            color: #007bff;
        }
        .link:hover {
            text-decoration: underline;
        }
        .user-info {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .user-info span {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); ?>
            <div class="info">
                <?php echo "<div class='user-info'>Witaj, <span>" . $_SESSION['imie'] . " " . $_SESSION['nazwisko'] . "</span></div>"; ?><br>
                Stan Twojego portfela: <?php echo $row['portfel']; ?> PLN<br>
            </div>
            <a class="link" href="user_admin_panel.php">Admin panel</a>
            <a class="link" href="user_admin_edit.php">Zmien dane</a>
            <a class="link" href="user_admin_portfel.php">Dodaj kase</a>
            <a class="link" href="/kantor/log.php">Wyloguj</a>
        <?php } else {
            echo "Nie znaleziono danych portfela.";
        } ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>

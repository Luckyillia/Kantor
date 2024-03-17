<!DOCTYPE html>
<html>
<head>
    <title>Панель пользователя</title>
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
        .user-panel {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            width: 300px;
        }
        .user-info {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .user-info span {
            color: #007bff;
        }
        .user-actions a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .user-actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="user-panel">
        <?php
        session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'User') {
            header("Location: /kantor/log.php");
            exit();
        }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kantor";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['user_id'];

        $sql = "SELECT imie, nazwisko, portfel FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='user-info'>Witaj, <span>" . $row['imie'] . " " . $row['nazwisko'] . "</span></div>";
            echo "<div>Stan Twojego portfela: " . $row['portfel'] . " PLN</div>";
            echo "<div class='user-actions'>";
            echo "<a href='user_panel.php'>Zmien</a>";
            echo "<a href='user_portfel.php'>Dodaj</a>";
            echo "<a href='/kantor/log.php'>Wyloguj</a>";
            echo "</div>";
        } else {
            echo "Nie znaleziono danych portfela.";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>

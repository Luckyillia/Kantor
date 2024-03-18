<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kantor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name";
$result = $conn->query($sql1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <div class="exchange-rate">
        <div class="exchange-rate-title">Kursy walut:</div>
       <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['name'];
                $length = strlen($name);
                $gif = substr($name, 0, $length - 1);

                echo "<div class='exchange-rate-item'>";
                if($row['name'] == 'eur'){
                    echo "<img src='https://www.waluty.pl/app/uploads/europeanunion.gif'>";
                }elseif ($row['name'] == 'uah') {
                    echo "<img src='https://www.waluty.pl/app/uploads/2015/12/ua.gif'>";
                }else{
                    echo "<img src='https://www.waluty.pl/app/uploads/",$gif,".gif'>";
                    
                }
                echo "<span>" . strtoupper($row['name']) . "</span>: " . $row['kurs'] . "</div>";
            }
        }else{
            echo "Brak danych o kursie walut.";
        }
        ?>
        <a href="kurs.php" class="refresh-button">Odśwież Kurs Walut</a>
    </div>
    <div class="exchange-rate2">
        <a href="/kantor/przeliczanie.php" class="refresh-button2">Przeliczanie</a>
    </div>
    <div class="container">
        <?php
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
        ?>
        <div class="info">
            <?php echo "<div class='user-info'>Witaj, <span>" . $_SESSION['imie'] . " " . $_SESSION['nazwisko'] . "</span></div>"; ?>
            <div class="user-info">Stan Twojego portfela: <?php
            $sql = "SELECT portfel FROM users WHERE user_id = $user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } 
            echo $row['portfel']; ?> PLN</div>
        </div>
        <div class="user-actions">
            <?php
            $check_sql = "SELECT COUNT(*) as count FROM portfel WHERE user_id = $user_id";
            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            if ($check_row['count'] < 1) {
                echo "<a href='/kantor/tworzenie_portfela.php?id=" . $user_id . "'>Stwórz portfele walutowe</a>";
            }?>
            <a class="link" href="user_admin_panel.php">Admin panel</a>
            <a class="link" href="user_admin_edit.php">Zmień dane</a>
            <a class="link" href="user_admin_portfel.php">Dodaj kasę</a>
            <a class="link" href="/kantor/log.php">Wyloguj</a>
        </div>
    </div>
</body>
</html>

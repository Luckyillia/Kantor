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

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='exchange-rate-item'><span>" . $row['name'] . "</span>: " . $row['kurs'] . "</div>";
            }
        } else {
            echo "Brak danych o kursie walut.";
        }

        $conn->close();
        ?>
        <a href="/kantor/kurs.php" class="refresh-button">Odśwież Kurs Walut</a>
    </div>
    <div class="exchange-rate2">
        <a href="/kantor/przeliczanie.php" class="refresh-button2">Przeliczanie</a>
    </div>
    <div class="container">
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

        $sql = "SELECT portfel FROM users WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
            <div class="info">
                <?php echo "<div class='user-info'>Witaj, <span>" . $_SESSION['imie'] . " " . $_SESSION['nazwisko'] . "</span></div>"; ?>
                <div class="user-info">Stan Twojego portfela: <?php echo $row['portfel']; ?> PLN</div>
            </div>
            <div class="user-actions">
                <a class="link" href="user_admin_panel.php">Admin panel</a>
                <a class="link" href="user_admin_edit.php">Zmień dane</a>
                <a class="link" href="user_admin_portfel.php">Dodaj kasę</a>
                <a class="link" href="/kantor/log.php">Wyloguj</a>
            </div>
        <?php } else {
            echo "Nie znaleziono danych portfela.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

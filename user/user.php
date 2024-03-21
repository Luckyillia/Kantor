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
    $sql = "SELECT kurs.data, waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id ORDER BY kurs.data DESC LIMIT 5";

    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Uzytkownika</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <div class="exchange-rate">
        <div class="exchange-rate-title">Kursy walut:</div>
       <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['name'];
                echo "<div class='exchange-rate-item'>";
                echo "<img src='/kantor/img/waluta/",$name,".png'>";
                echo "<span>" . strtoupper($name) . "</span>: " . $row['kurs'] . "</div>";
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

        $user_id = $_SESSION['user_id'];

        $sql = "SELECT imie, nazwisko, portfel FROM users WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='user-info'>Witaj, <span>" . $row['imie'] . " " . $row['nazwisko'] . "</span></div>";
            echo "<div class='user-info'>Stan Twojego portfela: " . $row['portfel'] . " PLN</div>";
            echo "<div class='user-actions'>";
            $check_sql = "SELECT COUNT(*) as count FROM portfel WHERE user_id = $user_id";
            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            if ($check_row['count'] < 1) {
                echo "<a class='link' href='/kantor/tworzenie_portfela.php?id=" . $user_id . "'>Stwórz portfele walutowe</a>";
            }
            $check_sql = "SELECT COUNT(*) as count FROM portfel WHERE user_id = $user_id";
            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            if ($check_row['count'] > 1) {
                echo "<a class='link' href='/kantor/usuwanie_portfela.php?id=" . $user_id . "'>Usun portfele walutowe</a>";
            }
            echo "<a class='link' href='user_panel.php'>Zmien</a>";
            echo "<a class='link' href='/kantor/portfel_panel.php'>Portfele Walutwe</a>";
            echo "<a class='link' href='user_portfel.php'>Dodaj Kase</a>";
            echo "<a class='link' href='/kantor/wyloguj.php'>Wyloguj</a>";
            echo "</div>";
        } else {
            echo "Nie znaleziono danych portfela.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

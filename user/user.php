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
        $sql = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name ORDER BY kurs DESC";

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

        $user_id = $_SESSION['user_id'];

        $sql = "SELECT imie, nazwisko, portfel FROM users WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='user-info'>Witaj, <span>" . $row['imie'] . " " . $row['nazwisko'] . "</span></div>";
            echo "<div class='user-info'>Stan Twojego portfela: " . $row['portfel'] . " PLN</div>";
            echo "<div class='user-actions'>";
            echo "<a href='user_panel.php'>Zmien</a>";
            echo "<a href='user_portfel.php'>Dodaj</a>";
            echo "<a href='/kantor/log.php'>Wyloguj</a>";
            echo "</div>";
        } else {
            echo "Nie znaleziono danych portfela.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

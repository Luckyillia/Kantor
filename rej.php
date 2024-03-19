<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="exchange-rate">
        <div class="exchange-rate-title">Kursy walut:</div>
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
        $sql = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name ORDER BY kurs.kurs DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['name'];
                echo "<div class='exchange-rate-item'>";
                echo "<img src='/kantor/img/waluta/",$name,".png'>";
                echo "<span>" . strtoupper($name) . "</span>: " . $row['kurs'] . "</div>";
            }
        } else {
            echo "Brak danych o kursie walut.";
        }
        ?>
        <a href="kurs.php" class="refresh-button">Odśwież Kurs Walut</a>
    </div>
    <div class="container">
        <?php
        if ($_POST) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];

            if ($password == $confirm_password) {
                $sql = "INSERT INTO users (imie, nazwisko, login, haslo, portfel,type) VALUES ('$name','$surname','$login','$password',0,'User')";
                $sql1 = "SELECT * FROM users WHERE login=?";
                $stmt = $conn->prepare($sql1);
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0){
                    echo "<div class='error-message'>Taki użytkownik już istnieje</div>";
                } else {
                    if ($conn->query($sql) === TRUE) {
                        header("Location: log.php"); // przekierowanie do strony logowania
                        exit();
                    } else {
                        echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
            } else {
                echo "<div class='error-message'>Hasła nie są takie same.</div>";
            }
        }
        ?>
        <form method="POST">
            <label for="login">Login:</label><br>
            <input type="text" id="login" name="login" required><br>
            <label for="password">Haslo:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Potwierdz haslo:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <label for="name">Imie:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="surname">Nazwisko:</label><br>
            <input type="text" id="surname" name="surname" required><br>
            <input type="submit" value="Zarejestruj sie">
        </form>
        <a href='log.php'>Zaloguj</a>
    </div>
</body>
</html>
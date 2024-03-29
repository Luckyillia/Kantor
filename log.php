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
$sql = "SELECT kurs.data, waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id ORDER BY kurs.data DESC LIMIT 5";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
    <link rel="stylesheet" href="css/styles.css">
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
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];

            $sql = "SELECT user_id, imie, nazwisko, login, type, portfel FROM users WHERE login = ? AND haslo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $login, $haslo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['nazwisko'] = $row['nazwisko'];
                $_SESSION['type'] = $row['type'];
                
                if ($row['type'] == 'User') {
                    header("Location: user/user.php"); // Przekierowanie do panelu użytkownika
                } elseif ($row['type'] == 'Admin') {
                    header("location: admin/user_admin.php"); // Przekierowanie do panelu admina
                }
            } else {
                echo "<div class='error-message'>Nieprawidłowy login lub hasło.</div>";
            }
            $stmt->close();
        }
        $conn->close();
        ?>
        <form method="post">
            <label for="login">Login: </label><br>
            <input type="text" name="login" required><br>
            <label for="password">Hasło: </label><br>
            <input type="password" name="haslo" required><br>
            <input type="submit" value="Zaloguj się" style="width: 94%;">
            <a href='rej.php' class='link under'>Zarejestruj</a>
        </form>
    </div>
</body>
</html>

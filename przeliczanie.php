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
$user_id = $_SESSION['user_id'];
$sql = "SELECT portfel FROM users WHERE user_id=$user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$portfel = $row['portfel'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator Walutowy</title>
    <link rel="stylesheet" href="/kantor/css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="user-info">Kalkulator Walutowy</h1>
        <form method="post" action="">
            <h1>Portfel:<?php echo $portfel;?></h1>
            <label for="amount">Kwota:</label>
            <input type="text" name="amount" value="" required>
            <br><br>
            <label for="currency">Wybierz walutę:</label>
            <select id="currency" name="currency">
                <option value="">--- Wybierz walutę ---</option>
                <?php
                $sql_currencies = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name";
                $result_currencies = $conn->query($sql_currencies);
                if ($result_currencies->num_rows > 0) {
                    while ($row_currency = $result_currencies->fetch_assoc()) {
                        echo "<option value='" . $row_currency['name'] . "'>" . $row_currency['name'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>
            <input type="submit" name="submit" value="Przelicz">
        </form>
        
        <?php
        if (isset($_POST['submit'])) {
            $amount = floatval($_POST['amount']);
            $currency = $_POST['currency'];

            $sql = "SELECT kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id WHERE waluta.name='$currency'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $exchange_rate = $row['kurs'];

                // Przelicz kwotę na PLN
                $resul = round($amount / $exchange_rate,2);
                echo "<h1 class='mini'>Wynik przeliczenia:<br> $amount PLN = $resul $currency</h1>";
            } else {
                echo "<p>Błąd: Brak kursu dla wybranej waluty.</p>";
            }
        }
        ?>
        
        <a href="<?php echo ($_SESSION['type'] == "Admin") ? '/kantor/admin/user_admin.php' : '/kantor/user/user.php'; ?>">Powrót</a>
    </div>
    <div class="container">
        <h1 class="user-info">Wymiana</h1>
        <form method="post" action="">
            <h1>Portfel:<?php echo $portfel;?></h1>
            <label for="amount">Kwota:</label>
            <input type="text" name="amount" value="" required>
            <br><br>
            <label for="currency">Wybierz walutę:</label>
            <select id="currency" name="currency">
                <option value="">--- Wybierz walutę ---</option>
                <?php
                $sql_currencies = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name";
                $result_currencies = $conn->query($sql_currencies);
                if ($result_currencies->num_rows > 0) {
                    while ($row_currency = $result_currencies->fetch_assoc()) {
                        echo "<option value='" . $row_currency['name'] . "'>" . $row_currency['name'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>
            <input type="submit" name="submit" value="Przelicz">
        </form>
        <a href="<?php echo ($_SESSION['type'] == "Admin") ? '/kantor/admin/user_admin.php' : '/kantor/user/user.php'; ?>">Powrót</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

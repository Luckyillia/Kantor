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
        <label for="amount">Kwota:</label>
        <input type="text" id="amount" name="amount" required>
        <br><br>
        <label for="currency">Wybierz walutę:</label>
        <select id="currency" name="currency">
            <option value="USD">Dolar amerykański (USD)</option>
            <option value="EUR">Euro (EUR)</option>
            <!-- Dodaj więcej opcji walutowych według potrzeb -->
        </select>
        <br><br>
        <input type="submit" name="submit" value="Przelicz">
    </form>
    
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
    $sql = "SELECT waluta.name, kurs.kurs FROM kurs INNER JOIN waluta ON kurs.waluta_id = waluta.id GROUP BY waluta.name";

    $result = $conn->query($sql);
    
    // Sprawdź, czy formularz został przesłany
    if(isset($_POST['submit'])){
        $amount = floatval($_POST['amount']);
        $currency = $_POST['currency'];

        // Pobierz kursy walut - można je pobrać z bazy danych
        while($row = $result->fetch_assoc()) {
            if ($row['name'] === $currency) {
                $exchange_rate = $row['kurs'];
                break;
            }
        }

        // Przelicz kwotę na PLN
        if (isset($exchange_rate)) {
            $result = $amount * $exchange_rate;
            // Wyświetl wynik
            echo "<p>Wynik przeliczenia: $amount $currency = $result PLN</p>";
        } else {
            echo "<p>Błąd: Brak kursu dla wybranej waluty.</p>";
        }
    }
    
    $conn->close();
    ?>
        <a href="<?php if($_SESSION['type'] == "Admin"){
            echo '/kantor/admin/user_admin.php';
        }else{
            echo '/kantor/user/user.php';
        } ?>">Powrot</a>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
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
            text-align: left; /* Добавлено для выравнивания текста по центру */
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
        a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            text-align: center;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
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
            <input type="submit" value="Zaloguj się">
            <a href='rej.php'>Zarejestruj</a>
        </form>
    </div>
</body>
</html>

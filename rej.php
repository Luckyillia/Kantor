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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kantor";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

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
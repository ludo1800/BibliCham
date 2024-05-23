<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" value=""><br><br>
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Se connecter">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "clients";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Utilisation de requêtes préparées
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $role = $row['role'];

            if ($role == 'admin') {
                header('Location: admin.php');
                exit();
            } elseif ($role == 'user') {
                header('Location: user.php');
                exit();
            }
        } else {
            header('Location: bad_user.php');
            exit();
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>

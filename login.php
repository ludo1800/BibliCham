<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Connexion au compte utilisateur</title>
</head>
<body>
    <h2>Connexion</h2>
    <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- sécuriser et afficher le chemin du script en cours d'exécution -->
        <label for="utilisateur">Nom d'utilisateur:</label><br>
        <input type="text" id="utilisateur" name="utilisateur" placeholder="Nom d'utilisateur…" value=""><br><br>
        <label for="mot_de_passe">Mot de passe:</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe…"><br><br>
        <input type="submit" value="Se connecter" class="btn-primary">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "biblicham";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_POST['utilisateur'];
        $password = $_POST['mot_de_passe'];

        // Utilisation de requêtes préparées
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $role = $row['role'];

            if ($role == 'admin') {
                session_start();
                $_SESSION['admin'] = true;
                header('Location: admin.php');
                exit();
            } elseif ($role == 'user') {
                session_start();
                $_SESSION['user'] = true;
                header('Location: user.php');
                exit();
            }
        } else {
            header('Location: login.php');
            echo "Nom d'utilisateur ou mot de passe incorrect";
            exit();
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>

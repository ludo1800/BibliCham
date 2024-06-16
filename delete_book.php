<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliCham";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['numero'])) {
    try {
        $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $id = $_GET['numero'];
        $sql = "DELETE FROM livres WHERE numero = :id";
        $stmt = $database->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: admin.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        exit;
    }
} else {
    echo "Requête non valide.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="admin.png" /> <!-- favicon -->
    <title>Admin - Ajouter un Livre - Injection Données</title>
    <link rel="stylesheet" href="add_book.css">
</head>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: add_book.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliCham";

try {
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $date_parution = $_POST['date_parution'];
        $isbn = $_POST['isbn'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $stock = $_POST['stock'];
        $image = $_POST['image'];

        $sql = "INSERT INTO livres (titre, auteur, date_parution, isbn, description, prix, stock, image) 
                VALUES (:titre, :auteur, :date_parution, :isbn, :description, :prix, :stock, :image)";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':date_parution', $date_parution);
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':image', $image);

        $stmt->execute();
        echo "Livre ajouté avec succès !<br><br>";
        echo "<p></p>";
        echo "<a href='admin_dashboard.php'><em>Ajouter un autre livre</em></a><br><br>";
        echo "<a href='biblicham.php'><em>Mise à jour page principale</em></a><br>";
        
        

    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$database = null;
?>

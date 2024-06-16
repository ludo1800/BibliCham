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

// var_dump($_POST['numero']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = isset($_POST['numero']) ? $_POST['numero'] : null;
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date_parution = $_POST['date_parution'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];

    // var_dump($numero);
    try {
        $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Déplacer l'image téléchargée dans le répertoire couvertures/
        move_uploaded_file($_FILES['image']['tmp_name'], "couvertures/" . $image);
        
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        exit;
    }

    // Validation des données (vous pouvez ajouter plus de validation ici)
    if (!empty($titre) && !empty($auteur) && !empty($date_parution)) {
        if ($numero) {
            // Mise à jour d'un livre existant
            $sql = "UPDATE livres SET titre = :titre, auteur = :auteur, date_parution = :date_parution, isbn = :isbn, description = :description, prix = :prix, stock = :stock, image = :image WHERE numero = :numero";
            $stmt = $database->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':auteur' => $auteur,
                ':date_parution' => $date_parution,
                ':isbn' => $isbn,
                ':description' => $description,
                ':prix' => $prix,
                ':stock' => $stock,
                ':image' => $image,
                ':numero' => $numero
            ]);
        } else {
            // Ajout d'un nouveau livre
            $sql = "INSERT INTO livres (titre, auteur, date_parution, isbn, description, prix, stock, image) VALUES (:titre, :auteur, :date_parution, :isbn, :description, :prix, :stock, :image)";
            $stmt = $database->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':auteur' => $auteur,
                ':date_parution' => $date_parution,
                ':isbn' => $isbn,
                ':description' => $description,
                ':prix' => $prix,
                ':stock' => $stock,
                ':image' => $image
            ]);
        }

        // Vérification de l'exécution de la requête
        if ($stmt->rowCount() > 0) {
            header("Location: admin.php?status=ok");
        } else {
            header("Location: admin.php?status=error");
        }
    } else {
        echo "Tous les champs sont requis.";
    }
} else {
    echo "Méthode de requête non prise en charge.";
}
?>

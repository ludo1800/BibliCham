
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

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$book = [
    'titre' => '',
    'auteur' => '',
    'date_parution' => '',
    'isbn' => '',
    'description' => '',
    'prix' => '',
    'stock' => '',
    ];

if (isset($_GET['numero'])) {
    $id = $_GET['numero'];
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE numero = :numero");
    $stmt->bindParam(':numero', $id, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$book) {
        die("Livre non trouvé.");
    }
}

// var_dump($book);
?>

<?php 
$title = "Ajouter un livre";
include "./components/header.php" 
?>

<?php if (isset($_GET["numero"])) :?>
    <h1>Modifier un livre</h1>
    <?php else :?>
    <h1>Ajouter un livre</h1>
    <?php endif ?>
<form method="post" action="process_form.php" class="admin-form" enctype="multipart/form-data">
            <?php if (isset($_GET["numero"])) :?>
                <input type="hidden" id="numero" name="numero"  value="<?php echo $_GET['numero'] ?>">
            <?php endif ?>
            <input type="text" id="titre" name="titre" placeholder="Titre…" value="<?php echo htmlspecialchars($book['titre']); ?>" required>
            <input type="text" id="auteur" name="auteur" placeholder="Auteur…" value="<?php echo htmlspecialchars($book['auteur']); ?>" required>
            <input type="number" id="date_parution" name="date_parution" value="<?php echo htmlspecialchars($book['date_parution']); ?>" placeholder="Année de Parution…" required>
            <input type="text" id="isbn" name="isbn" placeholder="ISBN…" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
            <textarea class="col-span" rows="5" id="description" name="description" placeholder="Résumé / 4ème de couverture…" r><?php echo htmlspecialchars($book['description']); ?></textarea>
            <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($book['prix']); ?>" placeholder="Prix…" step="0.01" required>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($book['stock']); ?>" placeholder="Stock…" required>


            <!-- <label for="file-upload" class="custom-file-upload">
            </label>
            <input id="file-upload" type="file" /> -->
            
            <!-- <label for="file-upload">Nom du fichier image…</label> -->
            <input type="file" id="image" name="image" class="col-span"  required placeholder="Nom du fichier image…">

            <!-- <input type="file" id="image" name="image" required><p></p> -->
            <div class="message-couv" style="color: rgb(30, 144, 255);">(Image de couverture normalement présente dans le répertoire 'couvertures\' en format jpeg et 600px min de large)<br><br></div>
            
            
            <div class="button-container">
                <button type="submit" class="btn-primary">Modifier le <b><u>livre</u></b></button>
            </div>
        </form>
<?php include "./components/footer.php" ?>
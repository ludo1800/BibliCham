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
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

$sql = "SELECT * FROM livres";
$request = $database->query($sql);
$livres = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$title = "Administration";
include "./components/header.php"
?>
<h1>Administration de la Bibliothèque</h1>
<!-- <a href="add_book.php">Ajouter un nouveau livre</a> -->

<?php if (isset($_GET['status'])) : ?>
    <?php if ($_GET['status'] === "ok") : ?>
        <p>Tout s'est bien passé !</p>
    <?php else : ?>
        <p>Problème !!!</p>
    <?php endif ?>
<?php endif ?>


<button id="add_book" target="_blank" class="btn-primary">Ajouter un <b>nouveau</b> livre</button>
<p></p>
<script>
    document.getElementById("add_book").addEventListener("click", function() {
        window.open("add_book.php", "_blank");
    });
</script>


<div class="table-responsive">
    <table>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Année de parution</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($livres as $livre) : ?>
            <tr>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= htmlspecialchars($livre['date_parution']) ?></td>
                <td><?= htmlspecialchars($livre['stock']) ?></td>
                <td>
                    <a class="btn-secondary underline" href="add_book.php?numero=<?= $livre['numero'] ?>">Modifier</a>
                    <!-- <button id="edit_book" target="_blank" href="edit_book.php?numero=<?= $livre['numero'] ?>">Modifier</button> -->

                    <a class="btn-secondary underline" class="btn-secondary" href="delete_book.php?numero=<?= $livre['numero'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- <a href="biblicham.php">Déconnexion. Retour au site</a> -->
<a href="biblicham.php" onclick="history.back()"><br>
    <button class="btn-primary">Retour à l'accueil <B>BibliCham</button>
</a>
<?php include "./components/footer.php" ?>
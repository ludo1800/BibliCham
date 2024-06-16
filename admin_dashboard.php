<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="admin.png" /> <!-- favicon -->
    <title>Admin - Ajouter un Livre - Saisie Données</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Ajouter un Nouveau Livre</h2>
        <form action="add_book.php" method="post" class="admin-form">
            <input type="text" id="titre" name="titre" placeholder="Titre…" required>
            <input type="text" id="auteur" name="auteur" placeholder="Auteur…" required>
            <input type="number" id="date_parution" name="date_parution" placeholder="Année de Parution…" required>
            <input type="text" id="isbn" name="isbn" placeholder="ISBN…" required>
            <textarea id="description" name="description" placeholder="Résumé / 4ème de couverture…" required></textarea>
            <input type="number" id="prix" name="prix" placeholder="Prix…" step="0.01" required>
            <input type="number" id="stock" name="stock" placeholder="Stock…" required>
            <input type="file" id="image" name="image" placeholder="Nom du fichier image…" required>
            <div class="message-couv"> (normalement présent dans le répertoire 'couvertures\' en format jpeg et 600px min de large)<br><br></div>
            <div class="button-container">
                <button type="submit">Ajouter le Livre</button>
            </div>
        </form>
    </div>
</body>
</html>
    
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit();
}
?>
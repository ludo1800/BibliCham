<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="edit_book.css" />
    <title>Modifier Livre</title>
</head>

<body>
<form method="POST" action="edit_book.php" class="form-container">
    <input type="hidden" name="numero" value="<?= htmlspecialchars($livre['numero']) ?>">

    <div class="form-group">
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>
    </div>

    <div class="form-group">
        <label for="auteur">Auteur:</label>
        <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>
    </div>

    <div class="form-group">
        <label for="date_parution">Date de parution:</label>
        <input type="text" id="date_parution" name="date_parution" value="<?= htmlspecialchars($livre['date_parution']) ?>" required>
    </div>

    <div class="form-group">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($livre['isbn']) ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($livre['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="prix">Prix:</label>
        <input type="text" id="prix" name="prix" value="<?= htmlspecialchars($livre['prix']) ?>" required>
    </div>

    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock" value="<?= htmlspecialchars($livre['stock']) ?>" required>
    </div>

    <div class="form-group">
        <button type="submit">Enregistrer les modifications</button>
    </div>
</form>
</body>
</html>

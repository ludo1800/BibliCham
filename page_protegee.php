
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page protégée</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Vous êtes connecté avec succès.</p>
</body>
</html>

<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Rediriger vers la page de connexion si non authentifié
    exit();
}
?>
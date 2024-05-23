<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="biblicham.css" />
    <link rel="icon" href="livres.png" /> <!-- favicon -->
    <script defer src="biblicham.js"></script>
    <title>BibliCham</title>
    
</head>
<body>
<div class="header">

    <div class="logo">
        <a href="contact.html" target="_blank">
            <img src="logo.jpg" alt="logo BibliCham">
        </a>
    </div>

    <div class="search">
        <form id="monFormulaire" method="GET" action="">
            <select class="option1" id="choix" name="tri">
                <option value="option1" <?= (isset($_GET['tri']) && $_GET['tri'] == 'option1') ? 'selected' : '' ?>>Tri par Titre</option>
                <option value="option2" <?= (isset($_GET['tri']) && $_GET['tri'] == 'option2') ? 'selected' : '' ?>>Tri par Auteur</option>
                <option value="option3" <?= (isset($_GET['tri']) && $_GET['tri'] == 'option3') ? 'selected' : '' ?>>Tri par Année</option>
            </select>

            <input type="text" id="saisie" name="saisie" placeholder="Rechercher un livre (dans Titre et Auteur)…" value="<?= isset($_GET['saisie']) ? htmlspecialchars($_GET['saisie']) : '' ?>">

            <button class="image-button" type="submit">
            <img src="loupe-bleue.png" width="40px" height="40"></button>
        </form>
    </div>

    <div class="nav_header">
        <a href="login.php" class="underline" target="_blank">Connexion</a> <!-- Lien vers la page de connexion comptes -->
        <a href="travaux.html" class="underline">Chèque cadeaux</>
        <a href="travaux.html" class="underline">Panier</a>
    </div>
</div> <!-- header -->

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliCham";

// Connexion à la base de données
try {
    $database = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Récupération des paramètres de tri et de recherche depuis l'URL
$tri = isset($_GET['tri']) ? $_GET['tri'] : 'option1'; // Par défaut, tri par titre
$saisie = isset($_GET['saisie']) ? $_GET['saisie'] : '';

// Construction de la requête SQL en fonction du paramètre de tri et de la saisie
$sql = "SELECT * FROM livres";
$params = [];

if (!empty($saisie)) {
    $sql .= " WHERE titre LIKE :saisie OR auteur LIKE :saisie";
    $params[':saisie'] = '%' . $saisie . '%';
}

switch ($tri) {
    case 'option1':
        $sql .= " ORDER BY titre";
        break;
    case 'option2':
        $sql .= " ORDER BY auteur";
        break;
    case 'option3':
        $sql .= " ORDER BY date_parution";
        break;
    default:
        // Option de tri par défaut
        $sql .= " ORDER BY titre";
        break;
}

// Exécution de la requête SQL
$request = $database->prepare($sql);
$request->execute($params);

echo "<div class='shelve'>";

// Affichage des livres triés
while ($livre = $request->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='book'>
        <img src='couvertures/" . $livre['image'] . "' alt='" . $livre['titre'] . "' style='width: 200px; height: 300px;' />";

        // Vérifier si le livre est en stock
        if ($livre['stock'] == 0) {
            echo "<div class='warning'>Non disponible actuellement</div>";
        }

        echo "<div class='summary'>";
            echo "<p class='titre'>Titre : " . $livre['titre'] . "</p>";
            echo "<p class='auteur'>Auteur : " . $livre['auteur'] . "</p>";
            echo "<p class='date_parution'>Année de parution : " . $livre['date_parution'] . "</p>";
            echo "<p class='isbn'>ISBN : " . $livre['isbn'] . "</p>";
            echo "<p class='description'>" . $livre['description'] . "</p>";
            echo "<p class='prix'>Prix : " . $livre['prix'] . " € ( " . $livre['stock'] . " en stock)</p>";
        echo "</div>"; // div summary
    echo "</div>"; // div book
} // while

echo "</div>"; // class shelve
?>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.getElementById('choix');
            selectElement.addEventListener('change', function() {
                document.getElementById('monFormulaire').submit();
            });
        });
    </script>
</body>
</html>

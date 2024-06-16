<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="livres.jpg" /> <!-- favicon -->
    <!-- <script defer src="db_first.js"></script> -->
    <title>DB Livres</title>

</head>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliCham";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Définir le fuseau horaire à utiliser (par exemple, Europe/Paris pour la France)
date_default_timezone_set('Europe/Paris');

// // Afficher la date et l'heure actuelles avec un format personnalisé
// $date = date('d/m/Y');  // Format : jour/mois/année heure:minute:seconde
// $heure = date('H:i:s'); // Format : jour/mois/année heure:minute:seconde
// echo "<p>La connexion à la base de données \"" . $dbname . "\"a réussi à <B>" . $heure . "</B> le <B>" . $date . "</B> !<br></p>";



// Requête pour vider la table livres (utilisation de TRUNCATE)
    $sql_truncate = "TRUNCATE TABLE livres";
    // echo "<p> Commande \"TRUNCATE TABLE livres\" passée pour vider <br> la base de données avant insertion des livres…<br><br></p>";

    // Exécuter la requête de vidage de la table
    if ($conn->query($sql_truncate) === FALSE) {
        die("Erreur lors du vidage de la table livres : " . $conn->error);
    }

// Liste des livres à insérer
$livres = [
    // ["0","Numéro","Titre","Auteur","Date de parution","ISBN","4ème de couverture","Disponibilité","Prix","Stock","Couverture"],
    ["01","Sapiens : Une brève histoire de l'humanité","Harari, Yuval Noah",2011,"978-2-02-109561-7","Sapiens raconte l'histoire de l'humanité depuis ses origines jusqu'à nos jours, en explorant les grandes révolutions qui ont façonné notre espèce. Ce livre passionnant et accessible nous invite à repenser notre place dans le monde.",1,22.90,5,"sapiens.jpeg"],
    ["02","Le Petit Prince","Saint-Exupéry, Antoine de",1943,"978-2-07-056734-4","Un aviateur perdu dans le désert rencontre un petit prince venu d'une autre planète. Leur rencontre poétique et philosophique nous invite à réfléchir sur le sens de la vie, l'amour et l'amitié.",0,7.90,0,"le_petit_prince.jpeg"],
    ["03","1984","Orwell, George",1949,"978-2-08-120242-8","Dans un monde totalitaire où la pensée est contrôlée par le gouvernement, un homme tente de préserver sa liberté et son individualité. Ce roman dystopique nous met en garde contre les dangers du totalitarisme et de la surveillance.",1,7.90,5,"1984.jpeg"],
    ["04","Crime et Châtiment","Dostoïevski, Fiodor",1866,"978-2-08-123108-5","Un jeune étudiant pauvre, rongé par la misère et le désespoir, commet un meurtre. Ce roman psychologique explore les profondeurs de l'âme humaine et les questions morales complexes qui se posent à l'individu.",1,9.90,5,"crime_et_chatiment.jpeg"],
    ["05","À la recherche du temps perdu","Proust, Marcel",1927,"978-2-08-121878-7","Un homme malade se remémore sa vie et tente de retrouver le temps perdu. Ce roman monumental, véritable chef-d'œuvre de la littérature française, explore la mémoire, l'amour, le temps et la condition humaine.",1,32.00,0,"temps_perdu.jpeg"],
    ["06","Les Misérables","Hugo, Victor",1862,"978-2-07-036537-4","Dans la France du XIXe siècle, un ancien forçat, Jean Valjean, tente de racheter ses erreurs et de vivre une vie honnête. Ce roman historique et social explore la pauvreté, la justice et la rédemption.",1,8.90,5,"miserables.jpeg"],
    ["07","Madame Bovary","Flaubert, Gustave",1857,"978-2-08-123111-5","Emma Bovary, une femme insatisfaite de son mariage et de sa vie provinciale, se lance dans des aventures extraconjugales qui la mèneront à sa perte. Ce roman réaliste dépeint avec finesse les illusions et les frustrations de la société bourgeoise du XIXe siècle.",1,7.90,5,"madame_bovary.jpeg"],
    ["08","L'Étranger","Camus, Albert",1942,"978-2-07-036538-1","Meursault, un homme indifférent et détaché du monde, tue un Arabe sur une plage d'Algérie. Ce roman existentialiste explore les thèmes de l'absurdité de la vie, de la liberté et de la responsabilité.",1,7.90,5,"etranger.jpeg"],
    ["09","La Ferme des animaux","Orwell, George",1945,"978-2-08-123110-8","Dans une ferme, les animaux se révoltent contre les humains et prennent le pouvoir. Mais rapidement, une nouvelle dictature s'instaure, pire encore que celle qu'ils avaient renversée. Ce conte satirique dénonce les dangers du totalitarisme et de la corruption.",1,7.90,5,"la_ferme_des_animaux.jpeg"],
    ["10","Le Tour du monde en quatre-vingts jours","Vernes, Jules",1873,"978-2-212-03172-4","Phileas Fogg, un gentleman londonien, parie qu'il peut faire le tour du monde en quatre-vingts jours. Il se lance alors dans un voyage extraordinaire en train, en bateau, en éléphant et en montgolfière, accompagné de son fidèle domestique Passepartout.",1,7.50,5,"80_jours.jpeg"],
    ["11","Frankenstein ou le Prométhée moderne","Shelly, Mary",1818,"978-2-07-043470-3","Un jeune scientifique, Victor Frankenstein, crée un être vivant en assemblant des parties de corps humains. Mais sa créature, monstrueuse et rejetée par la société, se venge de son créateur. Ce roman gothique explore les dangers de la science sans conscience et la question de l'humanité.",1,8.90,5,"frankenstein.jpeg"],
    ["12","Orgueil et Préjugés","Austen, Jane",1813,"978-2-253-16530-9","Elizabeth Bennet, une jeune femme intelligente et indépendante, refuse d'épouser un riche prétendant par simple sens du devoir. Elle attendra l'homme qui saura la séduire par son intelligence et son caractère. Ce roman d'amour et de société est un classique de la littérature anglaise.",1,7.20,5,"orgueil_prejuges.jpeg"],
    ["13","Gatsby le Magnifique","Fitzgerald, F. Scott",1925,"978-2-07-040132-6","Jay Gatsby, un mystérieux millionnaire, organise des fêtes somptueuses dans l'espoir de reconquérir son amour perdu, Daisy Buchanan. Ce roman emblématique de l'ère du jazz explore les thèmes de l'amour impossible, du rêve américain et de la décadence.",1,8.50,5,"gatsby.jpeg"],
    ["14","Ne tirez pas sur l'oiseau moqueur","Lee, Harper",1960,"978-2-02-009427-7","Scout Finch, une jeune fille vivant dans le sud des États-Unis pendant la Grande Dépression, raconte l'histoire du procès d'un homme noir accusé à tort de viol par un homme blanc. Ce roman puissant dénonce le racisme et l'intolérance.",1,9.90,5,"ne_tirez_pas.jpeg"],
    ["15","Cent ans de solitude","Márquez, Gabriel García",1967,"978-2-266-16986-5","Macondo, un village isolé en Amérique latine, connaît une histoire tumultueuse à travers sept générations de la famille Buendia. Ce roman magique mêle réalisme et fantastique pour explorer la solitude, la mémoire et la violence.",1,12.50,5,"cent_ans.jpeg"],
    ["16","Le Meurtre de Roger Ackroyd","Christie, Agatha",1926,"978-2-266-22201-3","Hercule Poirot, le célèbre détective belge, est appelé à enquêter sur le meurtre d'un riche homme dans un village anglais. Ce roman policier est considéré comme un chef-d'œuvre du genre par son intrigue déroutante et son dénouement surprenant.",1,7.90,5,"le_meurtre_de_roger.jpeg"],
    ["17","Ulysse","Joyce, James",1922,"978-2-08-121879-4","Léopold Bloom, un homme ordinaire, erre dans les rues de Dublin pendant une journée. Ce roman fleuve expérimental explore la vie quotidienne et les pensées intérieures de son personnage principal.",1,18.00,5,"ulysse.jpeg"],
    ["18","Le Portrait de Dorian Gray","Wilde, Oscar",1890,"978-2-253-15022-2","Dorian Gray, un jeune homme d'une beauté exceptionnelle, fait un pacte avec le diable : sa jeunesse restera éternelle, tandis que son portrait reflétera les marques du temps et du vice. Ce roman explore la vanité, la corruption et la double nature de l'homme.",1,7.80,5,"le_portrait_de_dorian_gray.jpeg"],
    ["19","Autant en emporte le vent","Mitchell, Margaret",1936,"978-2-266-12302-0","Scarlett O'Hara, une jeune femme rebelle et ambitieuse vivant dans le Sud des États-Unis pendant la guerre de Sécession, lutte pour sa survie et pour l'amour. Ce roman historique est une fresque passionnée qui dépeint la vie d'une femme forte dans une période tourmentée.",1,10.90,5,"autant_le_vent.jpeg"],
    ["20","Le silence des agneaux","Harris, Thomas",1988,"978-2-266-17430-2","Clarice Starling, une jeune stagiaire du FBI, est chargée d'interviewer Hannibal Lecter, un brillant psychiatre devenu tueur en série cannibale, afin d'obtenir des informations sur un autre meurtrier. Ce roman à suspense est devenu un classique du genre.",1,8.20,5,"silence_agneaux.jpeg"],
    ["21","Le Nom de la rose","Eco, Umberto",1980,"978-2-08-068844-7","Guillaume de Baskerville, un moine franciscain, enquête sur une série de meurtres mystérieux survenus dans une abbaye médiévale. Ce roman policier érudit mêle intrigue policière et réflexion philosophique sur la religion et la culture.",1,14.50,5,"nom_de_la_rose.jpeg"],
    ["22","Le Journal d'Anne Frank","Frank, Anne",1947,"978-2-232-12090-3","Anne Frank, une jeune fille juive vivant cachée à Amsterdam pendant la Seconde Guerre mondiale, raconte son quotidien dans son journal intime. Ce témoignage poignant est devenu un symbole de l'espoir et de la résistance face à la barbarie.",1,9.90,5,"anne_frank.jpeg"],
    ["23","Le Petit Prince retrouvé","Saint-Exupéry, Antoine de",1994,"978-2-07-059047-5","Recueil de manuscrits et de croquis préparatoires du Petit Prince, offrant un regard inédit sur la genèse de ce chef-d'œuvre de la littérature.",1,25.00,5,"petit_prince_retrouve.jpeg"],
    ["24","L'Alchimiste","Coelho, Paulo",1988,"978-2-266-14402-0","Santiago, un jeune berger espagnol, part à la recherche d'un trésor enfoui quelque part en Afrique du Nord. Son voyage initiatique lui permettra de découvrir le sens de la vie et de réaliser ses rêves.",1,7.50,5,"alchimiste.jpeg"],
    ["25","Sa Majesté des Mouches","Golding, William",1954,"978-2-07-036140-0","Un groupe d'enfants livrés à eux-mêmes sur une île déserte sombre rapidement dans la violence et la barbarie. Ce roman allégorique dénonce la nature sauvage de l'homme et la fragilité de la civilisation.",1,7.90,5,"majeste_mouches.jpeg"],
    ["26","Dune","Herbert,Frank",1965,"978-2-266-16944-4","Sur la planète désertique Arrakis, on trouve l'Épice, une substance vitale et précieuse. Paul Atréides, fils d'un duc envoyé pour gouverner la planète, se retrouve au cœur d'une lutte de pouvoir et d'une destinée hors du commun.",1,9.90,5,"dune.jpeg"],
    ["27","L'Oeuf du Dragon","Forward, Robert",1980,"978-2-221-01132-5","Sur une étoile à neutrons, à 50 années-lumière de la Terre, une civilisation minuscule mais avancée, les Cheela, évolue à une vitesse vertigineuse. Les humains, en découvrant ces créatures microscopiques, doivent repousser les limites de leur compréhension et de leur technologie pour établir un contact.",1,39.95,12,"oeuf_dragon.jpeg"],
    ["28","Vendredi ou les Limbes du Pacifique","Tournier, Michel",1967,"978-2-07-036038-7","(Suite) une réflexion sur l'identité, la colonisation et le rapport à l'autre.",1,8.90,5,"vendredi.jpeg"],
    ["29","Le Chant d'Achille","Miller, Madeline",2012,"978-2-266-27024-6","Racontée du point de vue de Patrocle, l'ami d'Achille, cette épopée revisite la guerre de Troie en explorant l'amitié, l'amour et la violence dans la mythologie grecque.",1,12.90,5,"chant_achille.jpeg"],
    ["30","Neverwhere","Gaiman, Neil",1996,"978-2-266-20532-0","Richard Mayhew, un jeune homme ordinaire, tombe accidentellement dans un monde souterrain secret de Londres, peuplé de créatures fantastiques et de dangers cachés.",1,8.50,5,"neverwhere.jpeg"],
    ["31","American Gods","Gaiman, Neil",2001,"978-2-266-18752-7","Shadow Moon, un ex-détenu, se retrouve au service de M. Wednesday, une mystérieuse divinité nordique, dans une guerre qui oppose les anciens dieux aux nouveaux dieux de l'Amérique moderne.",1,9.90,5,"american_gods.jpeg"],
    ["32","Le Problème à trois corps","Liu, Cixin",2006,"978-2-266-24922-8","La Terre reçoit un message extraterrestre menaçant. L'humanité, divisée et paranoïaque, doit s'unir pour faire face à une invasion imminente et à une intelligence technologique supérieure.",1,14.50,5,"le_probleme_trois_corps.jpeg"],
    ["33","Le Projet Hail Mary","Weir, Andy",2021,"978-2-266-31483-2","Ryland Grace, un astronaute amnésique, se réveille à bord d'un vaisseau spatial qu'il ne connaît pas et se lance dans une mission qu'il ignore pour sauver l'humanité.",1,22.00,5,"projet_hail_mary.jpeg"],
    ["34","Nos étoiles contraires","Green, John",2012,"978-2-10-059786-3","Hazel et Gus, deux adolescents atteints de cancer, tombent amoureux et partent à Amsterdam pour rencontrer leur auteur préféré. Une histoire d'amour touchante et réaliste sur la maladie et la vie.",1,7.90,5,"etoiles_contraires.jpeg"],
    ["35","Le Garçon au pyjama rayé","Boyne, John",2006,"978-2-02-089777-0","Bruno, un jeune garçon naïf vivant dans un camp de concentration nazi, se lie d'amitié avec Shmuel, un autre enfant juif prisonnier. Ce roman poignant explore l'innocence et l'horreur de la guerre à travers les yeux d'un enfant.",1,8.50,5,"garcon_pyjama_raye.jpeg"],
    ["36","La Couleur pourpre","Walker, Alice",1982,"978-2-07-042328-1","Celie, une femme afro-américaine maltraitée toute sa vie, se bat pour son indépendance et sa liberté dans le Sud des États-Unis du XXe siècle. Un roman puissant qui dénonce le racisme et le sexisme.",1,9.90,5,"couleur_pourpre.jpeg"],
    ["37","Jane Eyre","Brontë, Charlotte",1847,"978-2-253-16232-2","Jane Eyre, une jeune femme courageuse et indépendante, devient gouvernante dans un grand manoir et tombe amoureuse de son mystérieux employeur. Ce roman gothique explore les thèmes de l'amour, de la classe sociale et de l'émancipation féminine.",1,7.20,5,"jane_eyre.jpeg"],
    ["38","Le Maître et Marguerite","Boulgakov, Mikhaïl",1967,"978-2-07-040129-6","Dans un Moscou des années 1930 sous le régime stalinien, le Diable débarque et sème la pagaille, tandis qu'un maître anonyme brûle son roman sur Ponce Pilate et que Marguerite, sa muse, pactise avec le Diable pour le retrouver. Ce roman satirique et fantastique dénonce la censure et la folie dictatoriale.",1,10.90,5,"le_maitre_marguerite.jpeg"],
    ["39","Le meilleur des mondes","Huxley, Aldous",1932,"978-2-07-043469-7","Dans un futur dystopique, la société est parfaitement ordonnée et contrôlée, au détriment de la liberté et de l'individualité. Ce roman d'anticipation met en garde contre les dangers du totalitarisme et de l'uniformisation.",1,8.50,5,"meilleur_des_mondes.jpeg"],
    ["40","Fahrenheit 451","Bradbury, Ray",1953,"978-2-02-000232-2","Dans un monde où les livres sont interdits et brûlés par des pompiers spéciaux, un homme nommé Guy Montag, pompier lui-même, commence à se questionner et à se rebeller. Ce roman dystopique dénonce la censure et la manipulation des masses.",1,7.90,5,"fahrenheit_451.jpeg"],
    ["41","Orgueil et Préjugés et Zombies","Grahame-Smith, Seth",2009,"978-2-266-20909-2","Parodie mashup d'Orgueil et Préjugés de Jane Austen, où les sœurs Bennet doivent non seulement trouver l'amour, mais aussi combattre une invasion de zombies qui menace l'Angleterre.",1,12.50,5,"orgueil_prejuges_zombies.jpeg"],
    ["42","Les Fourmis","Werber, Bernard",1991,"978-2-266-06927-9","Dans un futur lointain, les fourmis ont évolué et développé une société complexe et fascinante. Ce roman de science-fiction explore l'intelligence collective, la place de l'homme dans l'univers et le sens de la vie.",1,8.90,5,"fourmis.jpeg"],
    ["43","Le crime de l'orient express","Christie, Agatha",1933,"978-2-266-11833-8","Hercule Poirot enquête sur un meurtre commis dans un train de luxe reliant Londres à Istanbul. Ce roman policier classique est connu pour son dénouement surprenant et son atmosphère unique.",1,7.50,5,"orient_express.jpeg"],
    ["44","Les dames du lac","Zimmer Bradley, Marion",1982,"978-2-266-16220-7","Premier tome de la saga Arthurienne de Marion Zimmer Bradley, qui revisite les légendes du roi Arthur et de la fée Morgane en adoptant le point de vue des femmes.",1,14.90,5,"dames_lac.jpeg"],
    ["45","Ne m'oublie pas","Larrivoire, Sirkku",2010,"978-2-246-77271-0","Un couple se sépare et décide de s'effacer mutuellement de leur mémoire grâce à une intervention médicale. Mais le doute et le regret s'installent, et ils remettent en question leur choix. Ce roman explore la mémoire, l'amour et la difficulté de l'oubli.",1,7.20,5,"ne_oublies_pas.jpeg"],
    ["46","Ils étaient dix (Dix petits nègres)","Christie, Agatha",1976,"978-2-266-22199-0","Miss Marple, la célèbre détective amateur, enquête sur une série de meurtres commis dans un paisible village anglais. Ce roman policier met en scène des personnages à priori ordinaires qui cachent de lourds secrets.",1,8.50,5,"10_negres.jpeg"],
    ["47","L'Écume des jours","Vian, Boris",1947,"978-2-02-000332-9","Colin, un jeune homme oisif et rêveur, tombe amoureux de Chloé, une jeune femme atteinte du nénuphar bleu, une maladie étrange qui lui pousse un nénuphar dans le poumon. Ce roman poétique et décalé est un classique de la littérature française du XXe siècle.",1,9.90,5,"ecume_des_jours.jpeg"],
    ["48","Le Parfum","Süskind, Patrick",1985,"978-2-08-067140-7","Jean-Baptiste Grenouille, né sans odorat, possède un odorat hors du commun. Obsédé par les odeurs, il devient un parfumeur génial et sombre, capable de recréer n'importe quel parfum. Ce roman explore l'odorat, le pouvoir des sens et la nature du mal.",1,10.50,5,"parfum.jpeg"],
    ["49","La Métamorphose","Kafka, Franz",1915,"978-2-07-040130-2","Gregor Samsa, un jeune commis voyageur, se réveille un matin transformé en insecte géant. Cette nouvelle absurde et angoissante explore l'aliénation, l'absurdité de la condition humaine et la confrontation à la différence.",1,7.50,5,"metamorphose.jpeg"],
    ["50","World War Z","Brooks, Max",2006,"978-2-266-18384-3","Racontée à travers des interviews de survivants du monde entier, cette œuvre de fiction décrit une apocalypse zombie d'une ampleur inédite et explore les réactions et les stratégies de survie face à une telle menace.",1,9.50,5,"world_war_z.jpeg"],
    ["51","Le Fléau","King, Stephen",1978,"978-2-266-13869-6","Une grippe mortelle se propage à travers les États-Unis, décimant la population. Une poignée de survivants, dirigés par la Mère Abigail, doivent trouver un moyen de reconstruire la société et de faire face à l'Homme en noir, une entité maléfique qui incarne le mal.",0,14.90,0,"fleau.jpeg"],
];

// Requête préparée pour l'insertion des livres
$sql = "INSERT INTO livres (numero, titre, auteur, date_parution, isbn, description, disponibilite, prix, stock, image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Préparation de la requête
$stmt = $conn->prepare($sql);

// Vérification de la préparation de la requête
if ($stmt === false) {
    die("Erreur de préparation de la requête : " . $conn->error);
}


$nbColonnes = 3; // Nombre de colonnes souhaité
$separateur = "   "; // Caractère de séparation (exemple : "|")

$i = 0;
echo "<table>"; // Début du tableau HTML

// Boucle pour insérer chaque livre dans la base de données
foreach ($livres as $livre) {
    // $image_path = "couvertures/" . $livre[9];
    $image_path = "" . $livre[9];
    
    // Liaison des paramètres avec les valeurs du livre
    $stmt->bind_param("ississidis", $livre[0], $livre[1], $livre[2], $livre[3], $livre[4], $livre[5], $livre[6], $livre[7], $livre[8], $image_path);
    
    // Exécution de la requête
    if (!$stmt->execute()) {
        echo "Erreur lors de l'insertion du livre : " . $stmt->error;
    }

    if ($i % $nbColonnes == 0) {
        echo "<tr>"; // Début d'une nouvelle ligne de tableau
    }

    // echo $livre[0].", ".$livre[1].$separateur; // Affichage de chaque titre injecté
    echo "<td>" . $livre[0].": ".$livre[1].$separateur . "</td>"; // Affichage du titre dans une cellule de tableau

    if ($i % $nbColonnes == $nbColonnes - 1) {
        echo "</tr>"; // Fin de la ligne de tableau
    }
    $i++;
} // foreach

echo "</table>"; // Fin du tableau HTML

$heure = date('H:i:s');
echo "<br><br><B>" . count($livres) . "</B> livres ont été ajoutés à <B>".$heure."</B> avec succès à la base de données vierge après vidange.<br><br><br>";

// Fermeture du statement
$stmt->close();

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!-- Bouton pour lancer BibliCham.php -->
<!-- <button id="site_biblicham" target="_blank">Accès au site <B>BibliCham</B></button> <!-- Nouvelle fenêtre -->
<button class="btn-primary" id="site_biblicham">Accès au site <B>BibliCham</B></button> <!-- Même fenêtre -->

<script>
    document.getElementById("site_biblicham").addEventListener("click", function() {
        window.open("biblicham.php"); // Même fenêtre
        //window.open("biblicham.php", "_blank"); // Nouvelle fenêtre
    });
    </script>
</body>
</html>


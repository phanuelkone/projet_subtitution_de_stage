<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération de l'id du deck et du choix de l'utilisateur
$deckselectid = $_POST['deckselectid'];
$userchoice = $_POST['userchoice'];

// Récupérer les decks de l'utilisateur choisi
$stmt = $pdo->prepare("SELECT * FROM deck WHERE id_user = :id");
$stmt->bindParam(':id', $userchoice, PDO::PARAM_INT);
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Decks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">

    <style>
        /* Styles pour la navbar */
        .navbar {
            width: 100%;
            background-color: #222;
            overflow: hidden;
            display: flex;
            justify-content: flex-start;
            padding: 20px 0;
            height: 100px; /* Augmenter la hauteur de la nav bar */
            align-items: center; /* Centrer verticalement les éléments */
        }

        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .navbar li {
            padding: 14px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center; /* Centrer verticalement les emojis */
        }

        .navbar a:hover {
            background-color: #575757;
        }

        .navbar .emoji {
            font-size: 20px;
            margin-right: 5px; /* Espacement entre le texte et l'emoji */
        }

        /* Styles pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #000;
            line-height: 1.4;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .decks-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .deck-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }

        .deck-item img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .deck-item h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .deck-item p {
            margin-bottom: 10px;
        }
        

        .add-to-cart-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        h2, h3 {
            color: #000;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="deck_main.php"><span class="emoji">🃏</span> market</a></li>
            <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
            <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
            <li><a href="exchange.php"><span class="emoji">🔄</span> demande d'echange</a></li>
            <li><a href="exchange_track.php"><span class="emoji">🔄</span> avancement  d'Échange</a></li>
            <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
            <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
        </ul>
    </div>

    <div class="container">
        <h3>Choisissez un deck pour l'échange</h3>
        <div class="decks-container">
            <?php if ($decks): ?>
                <?php foreach ($decks as $deck): ?>
                    <div class="deck-item">
                        <img src="img/<?php echo htmlspecialchars($deck['image']); ?>" alt="<?php echo htmlspecialchars($deck['nom']); ?>">
                        <h2>Nom : <?php echo htmlspecialchars($deck['nom']); ?></h2>

                        <form method="POST" action="change.php">
                            <input type="hidden" name="deckselectid" value="<?php echo $deckselectid; ?>">
                            <input type="hidden" name="deckchoice" value="<?php echo $deck['id']; ?>">
                            <input type="hidden" name="userchoice" value="<?php echo $userchoice; ?>">
                            <button type="submit">Demande d'échange</button>
                        </form>

                        <form method="POST" action="card_deck.php">
                            <input type="hidden" name="deckchoice" value="<?php echo $deck['id']; ?>">
                            <button type="submit">Voir les cartes</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun deck trouvé pour cet utilisateur.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

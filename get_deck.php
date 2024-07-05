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
    .h2, h3 {
            color: #000;
        }
        .h3, h2 {
            color: #000;
        }
</style>

<div class="navbar">
    <ul>
    <li><a href="deck_main.php"><span class="emoji">🃏</span>market</a></li>
        <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
        <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
        <li><a href="exchange.php"><span class="emoji">🔄</span> demande d'echange</a></li>
        <li><a href="exchange_track.php"><span class="emoji">🔄</span> avancement  d'Échange</a></li>
        <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
        <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
    </ul>
</div>

<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les decks de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM deck WHERE id_user = :userId");
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id_prod = $_POST['product_id'];

    if ($action == 'private') {
        // Mettre à jour la visibilité du deck à 'privé'
        $stmt = $pdo->prepare("UPDATE deck SET visibilite = 'private' WHERE id = :deckId");
        $stmt->bindParam(':deckId', $id_prod, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($action == 'public') {
        // Mettre à jour la visibilité du deck à 'pub'
        $stmt = $pdo->prepare("UPDATE deck SET visibilite = 'pub' WHERE id = :deckId");
        $stmt->bindParam(':deckId', $id_prod, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Redirection pour éviter le renvoi du formulaire lors d'un rafraîchissement de la page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Decks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #000; /* Changement de couleur en noir */
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
        .deck-item form {
            margin-top: 10px;
        }
        .deck-item form button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .deck-item form button:hover {
            background-color: #0056b3;
        }
        .h2, h3 {
            color: #000;
        }
        .h3, h2 {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="decks-container">
            <?php if ($decks): ?>
                <?php foreach ($decks as $deck): ?>
                    <div class="deck-item">
                        <img src="img/<?php echo htmlspecialchars($deck['image']); ?>" alt="<?php echo htmlspecialchars($deck['nom']); ?>">
                        <h2>nom :<?php echo htmlspecialchars($deck['nom']); ?></h2>
                        <h3>Description : <?php echo htmlspecialchars($deck['description']); ?></h3>
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?php echo $deck["id"]; ?>">
                            <?php if ($deck['visibilite'] == 'private'): ?>
                                <button type="submit" name="action" value="public">Rendre Public</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="private">Rendre Privé</button>
                            <?php endif; ?>
                        </form>
                        <!-- Ajout de boutons pour voir les cartes et échanger -->
                        <form method="POST" action="get_onecard.php">
                            <input type="hidden" name="product_id" value="<?php echo $deck["id"]; ?>">
                            <button type="submit">Voir les cartes <span class="emoji">🃏</span></button>
                        </form>
                        <form method="POST" action="userchoice.php">
                            <input type="hidden" name="product_id" value="<?php echo $deck["id"]; ?>">
                            <button type="submit">Échanger <span class="emoji">🔄</span></button>
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

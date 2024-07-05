<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=projet_tech_musee";
$username = "root";
$password = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Fonction pour vérifier si l'utilisateur a déjà liké le deck
function userHasLiked($pdo, $userId, $deckId) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM likes WHERE user_id = :userId AND deck_id = :deckId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

// Gestion du like/dislike d'un deck
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && ($_POST['action'] == 'like' || $_POST['action'] == 'dislike')) {
        $deckId = $_POST['deck_id'];

        if ($_POST['action'] == 'like') {
            if (!userHasLiked($pdo, $userId, $deckId)) {
                $stmt = $pdo->prepare("INSERT INTO likes (user_id, deck_id) VALUES (:userId, :deckId)");
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
                $stmt->execute();

                $stmt = $pdo->prepare("UPDATE deck SET liker = liker + 1 WHERE id = :deckId");
                $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
                $stmt->execute();
            }
        } 
    }
}

// Récupération des decks publics de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM deck WHERE visibilite = 'pub'");
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        .deck-item .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .deck-item .stats .emoji {
            margin-right: 5px;
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
    </style>
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="deck_main.php"><span class="emoji">🃏</span>Market</a></li>
        <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
        <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
        <li><a href="exchange.php"><span class="emoji">🔄</span> demande d'echange</a></li>
        <li><a href="exchange_track.php"><span class="emoji">🔄</span> avancement  d'Échange</a></li>
        <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
        <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
    </ul>
</div>

<div class="container">
    <div class="decks-container">
        <?php if ($decks && count($decks) > 0): ?>
            <?php foreach ($decks as $deck): ?>
                <div class="deck-item">
                    <img src="img/<?php echo htmlspecialchars($deck['image']); ?>" alt="<?php echo htmlspecialchars($deck['nom']); ?>">
                    <h2><?php echo htmlspecialchars($deck['nom']); ?></h2>
                    <p>Description : <?php echo htmlspecialchars($deck['description']); ?></p>
                    <!-- Affichage des likes et vues -->
                    <div class="stats">
                        <form method="POST" action="">
                            <input type="hidden" name="deck_id" value="<?php echo $deck['id']; ?>">
                            <?php if (!userHasLiked($pdo, $userId, $deck['id'])): ?>
                                <button type="submit" name="action" value="like"><span class="emoji">👍</span> <?php echo htmlspecialchars($deck['liker']); ?> Likes</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="dislike"><span class="emoji">👎</span> <?php echo htmlspecialchars($deck['liker']); ?> Likes</button>
                            <?php endif; ?>
                            <span><span class="emoji">👁️</span> <?php echo htmlspecialchars($deck['vue']); ?> Vues</span>
                        </form>
           
                    </div>
                    <!-- Formulaires pour actions -->
                    <form method="POST" action="get_onecard.php">
                        <input type="hidden" name="product_id" value="<?php echo $deck['id']; ?>">
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

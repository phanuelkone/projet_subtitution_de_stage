<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

// Verify that the product_id is set and is a number
if (!isset($_POST["product_id"]) || !is_numeric($_POST["product_id"])) {
    die('Invalid product ID');
}

// ID of the selected deck
$card = (int)$_POST["product_id"];

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch products associated with the cards of the deck
$stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit =:id_card");
$stmt->bindParam(':id_card', $card, PDO::PARAM_INT);
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);


























?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
    
</style>

<div class="navbar">
    <ul>
    <li><a href="deck_main.php"><span class="emoji">🃏</span>market</a></li>
        <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
        <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
        <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
        <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
    </ul>
</div>


</body>
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
    </style>
</html>

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
        .add-to-cart-btn:hover {
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
                        <img src="img/<?php echo htmlspecialchars($deck['picture']); ?>" alt="<?php echo htmlspecialchars($deck['nom_produit']); ?>">
                        
                      
                        

                        
                    </div>

                    <div class="deck-item">
                    
                        <h2>Nom: <?php echo htmlspecialchars($deck['nom_produit']); ?></h2>
                        <h3>Description: <?php echo htmlspecialchars($deck['description_produit']); ?></h3>
                        <h3>type: <?php echo htmlspecialchars($deck['type']); ?></h3>
                        <h3>fraction: <?php echo htmlspecialchars($deck['fraction']); ?></h3>
                        <h3>rarete: <?php echo htmlspecialchars($deck['rarete']); ?></h3>
                     
                     
                     
                     
                        

                       
                    </div>
                    

                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun deck trouvé pour cet utilisateur.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

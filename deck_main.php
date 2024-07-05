<?php
require_once('functions.php');
require_once('_head.php');

// Connexion à la base de données
$bdd = connect();

// Initialisation des variables de filtre
$rarity = isset($_GET['rarity']) ? $_GET['rarity'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$factions = isset($_GET['factions']) ? $_GET['factions'] : '';

// Construction de la requête SQL avec les filtres
$sql = "SELECT * FROM produit WHERE 1=1";

if ($rarity !== '') {
    $sql .= " AND rarete = :rarity";
}
if ($type !== '') {
    $sql .= " AND type = :type";
}
if ($factions !== '') {
    $sql .= " AND fraction = :factions";
}

$sth = $bdd->prepare($sql);

// Liaison des paramètres
if ($rarity !== '') {
    $sth->bindParam(':rarity', $rarity, PDO::PARAM_STR);
}
if ($type !== '') {
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
}
if ($factions !== '') {
    $sth->bindParam(':factions', $factions, PDO::PARAM_STR);
}

$sth->execute();
$products = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Site</title>
    <style>
        /* Styles pour la navbar */
        .navbar {
            width: 100%;
            background-color: #222;
            overflow: hidden;
            display: flex;
            justify-content: flex-start;
            padding: 20px 0;
            height: 50px;
            align-items: center;
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
            color: black;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        .navbar .emoji {
            font-size: 20px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="deck_main.php"><span class="emoji">🃏</span> Market</a></li>
            <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
            <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
            <li><a href="exchange.php"><span class="emoji">🔄</span> Mes demandes d'échange</a></li>
            <li><a href="exchange_track.php"><span class="emoji">🔄</span> Avancement d'Échange</a></li>
            <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
            <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
        </ul>
    </div>

    <!-- start tri-corps -->
    <div class="container">
        <div id="electrique" class="section">
            <div class="content">
                <h1>Découvrez notre site 100% TCG</h1>
                <h4><a href="afrique.php">Découvrez l'Afrique en peinture.</a></h4>
            </div>
            <div class="overlay"></div>
        </div>
        <div id="disponibles" class="section">
            <div class="content">
                <h1>Nos modèles disponibles immédiatement</h1>
                <h4><a href="get_all_deck.php">Accédez à la boutique et découvrez.</a></h4>
            </div>
            <div class="overlay"></div>
        </div>
        <div id="rs" class="section">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <span><div class="rhombus"></div></span>
                        <h1>Tendance</h1>
                    </div>
                </div>
                <h4><a href="sape.php">Découvrez notre rubrique 100% mode.</a></h4>
            </div>
            <div class="overlay"></div>
        </div>
    </div>
    <!-- fin tri-corps -->

    <br>

    <!-- START etage 2-->
    <header></header>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        
        nav {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }
        
        nav a {
            text-decoration: none;
            color: #333;
            padding: 10px;
            margin: 0 5px;
        }
        
        .product {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        
        .product-item {
            width: 300px;
            margin: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        
        .product-item img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        
        .add-to-cart-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>

    <!-- Formulaire de tri -->
    <form method="get" action="">
        <label for="rarity">Trier par rareté :</label>
        <select name="rarity" id="rarity">
            <option value="">Tous</option>
            <option value="unique" <?= $rarity == 'unique' ? 'selected' : '' ?>>Unique</option>
            <option value="commun" <?= $rarity == 'commun' ? 'selected' : '' ?>>Commun</option>
            <option value="rare" <?= $rarity == 'rare' ? 'selected' : '' ?>>Rare</option>
        </select>

        <label for="type">Trier par type :</label>
        <select name="type" id="type">
            <option value="">Tous</option>
            <option value="Hero" <?= $type == 'Hero' ? 'selected' : '' ?>>Hero</option>
            <option value="mana" <?= $type == 'mana' ? 'selected' : '' ?>>Mana</option>
            <option value="token character" <?= $type == 'token character' ? 'selected' : '' ?>>Token Character</option>
            <option value="spell" <?= $type == 'spell' ? 'selected' : '' ?>>Spell</option>
            <option value="permanent" <?= $type == 'permanent' ? 'selected' : '' ?>>Permanent</option>
        </select>

        <label for="factions">Trier par factions :</label>
        <select name="factions" id="factions">
            <option value="">Tous</option>
            <option value="axiom" <?= $factions == 'axiom' ? 'selected' : '' ?>>Axiom</option>
            <option value="bravos" <?= $factions == 'bravos' ? 'selected' : '' ?>>Bravos</option>
            <option value="lyra" <?= $factions == 'lyra' ? 'selected' : '' ?>>Lyra</option>
            <option value="muma" <?= $factions == 'muma' ? 'selected' : '' ?>>Muma</option>
            <option value="ordis" <?= $factions == 'ordis' ? 'selected' : '' ?>>Ordis</option>
            <option value="yzmir" <?= $factions == 'yzmir' ? 'selected' : '' ?>>Yzmir</option>
        </select>

        <button type="submit">Trier</button>
    </form>

    <div class="video-bar">
        <!-- Insérez ici le code pour intégrer votre vidéo -->
    </div>
    <div class="product-container">
        <div class="product">
            <?php
            foreach ($products as $product) {
                echo '<div class="product-item">';
                echo '<img src="img/' . htmlspecialchars($product["picture"]) . '" alt="' . htmlspecialchars($product["nom_produit"]) . '">';
                echo '<h2>' . htmlspecialchars($product["nom_produit"]) . '</h2>';
                echo '<p>' . htmlspecialchars($product["description_produit"]) . '</p>';
                echo '<p>' . number_format($product["prix"], 2, ',', '.') . ' €</p>';
                echo '<a href="payement.php?id=' . $product["id_produit"] . '" class="add-to-cart-btn">Voir</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="shop-now">
        <a href="#" class="shop-now-btn">Shop Now</a>
    </div>
</body>
</html>

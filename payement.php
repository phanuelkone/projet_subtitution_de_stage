<?php
require_once 'functions.php';
require_once 'Session.php';
use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $assignedTo = $_POST['assigned_to'];
    $quantity = 1; // Ajustez cette valeur selon vos besoins
    $bdd = connect();

    try {
        $sql = "INSERT INTO deck_cartes (DeckID, CardID, Quantite) VALUES (:deck_id, :card_id, :quantity)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':deck_id', $assignedTo, PDO::PARAM_INT);
        $stmt->bindParam(':card_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
        echo "Carte ajoutée à la collection.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

if (isset($_GET['id'])) {
    $bdd = connect();
    $productId = $_GET['id'];
    $sql = "SELECT * FROM produit WHERE id_produit = :id";
    $sth = $bdd->prepare($sql);
    $sth->bindValue(':id', $productId, PDO::PARAM_INT);
    $sth->execute();
    $product = $sth->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ajouter à la Collection</title>
            <style>
                /* Styles généraux */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #333;
                    color: #fff;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    height: 100vh;
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                }
                .navbar {
                    width: 100%;
                    background-color: #222;
                    overflow: hidden;
                    display: flex;
                    justify-content: flex-start;
                    padding: 20px 0;
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
                    display: block;
                }
                .navbar a:hover {
                    background-color: #575757;
                }
                .container {
                    width: 100%;
                    max-width: 800px;
                    padding: 20px;
                    box-sizing: border-box;
                    display: flex;
                    justify-content: center;
                }
                .product-item {
                    background-color: #444;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .product-item img {
                    width: 100%;
                    max-width: 300px;
                    object-fit: cover;
                    border-radius: 8px;
                    margin-bottom: 20px;
                }
                .product-item h2 {
                    font-size: 28px;
                    margin-bottom: 10px;
                }
                .product-item p {
                    margin-bottom: 20px;
                }
                .buy-form {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .buy-form button {
                    padding: 12px 24px;
                    font-size: 16px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    margin-top: 10px;
                }
                .buy-form button:hover {
                    background-color: #0056b3;
                }
                .form-group {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    width: 100%;
                }
                .form-group label {
                    font-size: 18px;
                    margin-bottom: 8px;
                    color: #bbb;
                }
                .form-group select {
                    padding: 10px;
                    width: 100%;
                    max-width: 400px;
                    background-color: #555;
                    color: #fff;
                    border: 1px solid #777;
                    border-radius: 4px;
                }
                .form-group select:focus {
                    outline: none;
                    border-color: #007bff;
                }
            </style>
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
        height: 50px; /* Augmenter la hauteur de la nav bar */
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
        <li><a href="exchange.php"><span class="emoji">🔄</span>mes demande d'echange</a></li>
        <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
        <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
    </ul>
</div>
            </div>
            <div class="container">
                <div class="product-item">
                    <img src="img/<?php echo htmlspecialchars($product["picture"]); ?>" alt="<?php echo htmlspecialchars($product["nom_produit"]); ?>">
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($product["nom_produit"]); ?></h2>
                        <p><?php echo htmlspecialchars($product["description_produit"]); ?></p>
                        <form class="buy-form" method="POST" action="add_deck.php">
                            <h1>Ajouter à la Collection</h1>
                            <div class="form-group">
                                <label for="nom">Assigné à :</label>
                                <select id="nom" name="nom">
                                    <?php
                                    // Connexion à la base de données avec PDO
                                    $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $userId = $session->getCurrentUserID();
                                    // Récupérer la liste des decks depuis la base de données
                                    $stmt =  $pdo->prepare("SELECT * FROM deck WHERE id_user = :userId");
                                    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $decks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Afficher les options de la liste déroulante pour les decks
                                    foreach ($decks as $deck) {
                                        echo "<option value='" . $deck['nom'] . "'>" . htmlspecialchars($deck['nom']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            
                    <div class="deck-item">
                    
                    <h2>Nom: <?php echo htmlspecialchars($product['nom_produit']); ?></h2>
                    <h3>Description: <?php echo htmlspecialchars($product['description_produit']); ?></h3>
                    <h3>type: <?php echo htmlspecialchars($product['type']); ?></h3>
                    <h3>fraction: <?php echo htmlspecialchars($product['fraction']); ?></h3>
                    <h3>rarete: <?php echo htmlspecialchars($product['rarete']); ?></h3>
                 
                 
                 
                 
                    

                   
                </div>
                
                            <input type="hidden" name="product_id" value="<?php echo $product["id_produit"]; ?>">
                            <input type="hidden" name="quantity" value="1"> <!-- Ajustez cette valeur selon vos besoins -->
                            <button type="submit">Ajouter à ma collection</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo '<p>Le produit sélectionné n\'existe pas.</p>';
    }
} else {
    echo '<p>Aucun produit sélectionné.</p>';
}
?>

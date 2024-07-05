<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification que l'utilisateur est connecté
    if ($userId) {
        // Récupérer les demandes d'échange où l'utilisateur est le receveur
        $stmt = $pdo->prepare("SELECT partage.*, proposeur.username as proposeur_username, receveur.username as receveur_username, 
                                      deck_propose.nom as deck_propose_nom, deck_demande.nom as deck_demande_nom
                               FROM partage
                               JOIN users AS proposeur ON partage.proposeurID = proposeur.id
                               JOIN users AS receveur ON partage.receveurID = receveur.id
                               JOIN deck AS deck_propose ON partage.deckproposID = deck_propose.id
                               JOIN deck AS deck_demande ON partage.deckdemandID = deck_demande.id
                               WHERE partage.receveurID = :userId AND partage.statut = 'refuser'");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Gérer l'acceptation ou le refus des échanges
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['demande_id'])) {
    $demandeId = $_POST['demande_id'];
    $action = $_POST['action']; // 'accept' ou 'reject'

    try {
        if ($action == 'accept') {
            // Commencer une transaction pour l'acceptation de l'échange
            $pdo->beginTransaction();

            // Récupérer les détails de la demande d'échange
            $stmt = $pdo->prepare("SELECT * FROM partage WHERE id = :demandeId");
            $stmt->bindParam(':demandeId', $demandeId, PDO::PARAM_INT);
            $stmt->execute();
            $demande = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($demande) {
                // Échanger les decks entre les utilisateurs
                $stmt = $pdo->prepare("UPDATE deck SET id_user = CASE 
                                        WHEN id = :deckProposID THEN :receveurID
                                        WHEN id = :deckDemandID THEN :proposeurID
                                        END
                                        WHERE id IN (:deckProposID, :deckDemandID)");
                $stmt->bindParam(':deckProposID', $demande['deckproposID'], PDO::PARAM_INT);
                $stmt->bindParam(':deckDemandID', $demande['deckdemandID'], PDO::PARAM_INT);
                $stmt->bindParam(':receveurID', $demande['receveurID'], PDO::PARAM_INT);
                $stmt->bindParam(':proposeurID', $demande['proposeurID'], PDO::PARAM_INT);
                $stmt->execute();

                // Mettre à jour le statut de la demande d'échange à 'accepte'
                $stmt = $pdo->prepare("UPDATE partage SET statut = 'accepte' WHERE id = :demandeId");
                $stmt->bindParam(':demandeId', $demandeId, PDO::PARAM_INT);
                $stmt->execute();

                // Valider la transaction
                $pdo->commit();
                echo "Échange accepté et decks échangés avec succès.";
            } else {
                throw new Exception("Demande d'échange introuvable.");
            }
        } elseif ($action == 'reject') {
            // Refuser l'échange
            $stmt = $pdo->prepare("UPDATE partage SET statut = 'refuser' WHERE id = :demandeId");
            $stmt->bindParam(':demandeId', $demandeId, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Rafraîchir la page pour mettre à jour la liste des demandes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "Erreur lors de l'acceptation de l'échange : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes d'Échange</title>
    <link rel="stylesheet" href="styles.css">
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

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 60px; /* Ajout de marge pour éviter le chevauchement avec la navbar */
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

        .deck-item h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .deck-item p {
            margin-bottom: 10px;
        }

        .deck-item form {
            display: inline-block;
            margin-right: 10px;
        }

        .deck-item button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .deck-item button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="deck_main.php"><span class="emoji">🃏</span> Market</a></li>
        <li><a href="create_deck.php"><span class="emoji">🃏</span> Créer Deck</a></li>
        <li><a href="get_deck.php"><span class="emoji">📚</span> Afficher Mes Decks</a></li>
        <li><a href="exchange.php"><span class="emoji">🔄</span> Mes Demandes d'Échange</a></li>
        <li><a href="exchange_track.php"><span class="emoji">🔄</span> avancement  d'Échange</a></li>
        <li><a href="get_all_deck.php"><span class="emoji">🔍</span> Tous Les Decks</a></li>
        <li><a href="logout.php"><span class="emoji">🔓</span> Déconnexion</a></li>
    </ul>
</div>

<div class="content">
    <div class="container">
        <h1>Demandes d'Échange</h1>
        <div class="decks-container">
            <?php if (!empty($demandes)): ?>
                <?php foreach ($demandes as $demande): ?>
                    <div class="deck-item">
                        <h2>Proposé par : <?php echo htmlspecialchars($demande['proposeur_username']); ?></h2>
                        <p>Deck proposé : <?php echo htmlspecialchars($demande['deck_propose_nom']); ?></p>
                        <p>Deck demandé : <?php echo htmlspecialchars($demande['deck_demande_nom']); ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="demande_id" value="<?php echo $demande['id']; ?>">
                            <button type="submit" name="action" value="accept">Accepter</button>
                            <button type="submit" name="action" value="reject">Refuser</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune demande d'échange trouvée.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>

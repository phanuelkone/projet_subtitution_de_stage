<?php
require_once 'Session.php';
use App\Session;

$session = new Session();
date_default_timezone_set('Europe/Paris');

// Vérifier si l'utilisateur est connecté
$isconnected = $session->isConnected();
$token_name = "user_token";

// Vérifier si le jeton est toujours valide
if ($isconnected && isset($_COOKIE['user_token'])) {
    $user_token = $_COOKIE['user_token'];

    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'utilisateur actuel
    $userId = $session->getCurrentUserID();

    // Requêter la base de données pour récupérer le jeton de l'utilisateur
    $stmt = $pdo->prepare("SELECT token, expiry_time FROM user_sessions WHERE user_id = :userId ORDER BY expiry_time DESC");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    date_default_timezone_set('Europe/Paris');
    if ($row && $row['token'] === $user_token && $row['expiry_time'] > date('Y-m-d H:i:s')) {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $title = $_POST['nom'];
            $card = $_POST['product_id'];

            try {
                $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupérer l'ID du deck sélectionné
                $stmt = $pdo->prepare("SELECT id FROM deck WHERE nom = :nom");
                $stmt->bindParam(':nom', $title);
                $stmt->execute();
                $deck = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($deck) {
                    $deckId = $deck['id'];

                    // Insérer la carte dans le deck
                    $stmt = $pdo->prepare("INSERT INTO decks (deck_id, card_id) VALUES (:deck_id, :card_id)");
                    $stmt->bindParam(':deck_id', $deckId, PDO::PARAM_INT);
                    $stmt->bindParam(':card_id', $card, PDO::PARAM_INT);
                  
                    $stmt->execute();

                    // Afficher un message de réussite
                    echo '<script>alert("Carte ajoutée avec succès à la collection."); window.location.href = "deck_main.php";</script>';
                } else {
                    echo "Erreur : Le deck sélectionné n'existe pas.";
                }

            } catch (PDOException $e) {
                // Afficher les erreurs PDO
                echo "Erreur lors de l'ajout de la carte : " . $e->getMessage();
            }
        }
    } else {
        $deleteTokenSql = "DELETE FROM user_sessions WHERE user_id = :userId AND token = :token";
        $deleteTokenStmt = $pdo->prepare($deleteTokenSql);
        $deleteTokenStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $deleteTokenStmt->bindParam(":token", $user_token, PDO::PARAM_STR);
        $deleteTokenStmt->execute();

        $session->destroy();
        $session->deleteCookie();
        echo '<script>alert("Votre session a expiré. Veuillez vous reconnecter."); window.location.href = "index.php";</script>';
        exit;
    }

} else {
    header("location: index.php");
    exit;
}
?>

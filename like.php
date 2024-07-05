<?php
require_once('functions.php');
require_once('Session.php');

use App\Session;

$session = new Session();
$userId = $session->getCurrentUserID();

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les decks publics de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM deck WHERE visibilite = 'pub'");
$stmt->execute();
$decks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour vérifier si l'utilisateur a déjà liké le deck
function userHasLiked($pdo, $userId, $deckId) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM likes WHERE user_id = :userId AND deck_id = :deckId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

// Fonction pour gérer le like d'un deck
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'like') {
        $deckId = $_POST['deck_id'];

        // Vérifier si l'utilisateur a déjà liké ce deck
        if (!userHasLiked($pdo, $userId, $deckId)) {
            // Mettre à jour la table des likes
            $stmt = $pdo->prepare("INSERT INTO likes (user_id, deck_id) VALUES (:userId, :deckId)");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
            $stmt->execute();

            // Mettre à jour le compteur de likes dans la table des decks
            $stmt = $pdo->prepare("UPDATE deck SET liker = liker + 1 WHERE id = :deckId");
            $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}

// Fonction pour gérer la vue d'un deck
function incrementViewCount($pdo, $deckId) {
    $stmt = $pdo->prepare("UPDATE deck SET vue = vue + 1 WHERE id = :deckId");
    $stmt->bindParam(':deckId', $deckId, PDO::PARAM_INT);
    $stmt->execute();
}


header("location: get_all_deck.php");




?>
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

    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost;dbname=tpo", "root", "");
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
                $title = $_POST['title'];
                $description = $_POST['description'];
                $status = $_POST['status'];
                $assigned_to = $_POST['assigned_to'];

                // Récupérer l'ID de l'utilisateur actuel

                try {
                    // Connexion à la base de données avec PDO
                    $pdo = new PDO("mysql:host=localhost;dbname=tpo", "root", "");

                    // Configuration de PDO pour lancer des exceptions en cas d'erreur
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Vérifier si l'email existe dans la table des utilisateurs
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email=:email");
                    $stmt->bindParam(':email', $assigned_to);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        // L'email existe, procéder à l'insertion de la tâche
                        // Préparer la requête d'insertion avec des paramètres nommés
                        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status, assigned_to, created_by) VALUES (:title, :description, :status, :assigned_to, :created_by)");

                        // Liaison des valeurs des paramètres nommés
                        $stmt->bindParam(':title', $title);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':status', $status);
                        $stmt->bindParam(':assigned_to', $user['id']);
                        $stmt->bindParam(':created_by', $id);
                        $stmt->execute();

                        // Afficher un message de réussite
                        echo '<script>alert("Tâche créée avec succès"); window.location.href = "dashboard.php";</script>';
                    } else {
                        // L'email n'existe pas, afficher un message d'erreur
                        echo "Erreur : L'email spécifié n'existe pas dans la base de données.";
                    }

                } catch (PDOException $e) {
                    // Afficher les erreurs PDO
                    echo "Erreur lors de la création de la tâche : " . $e->getMessage();
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
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    header("location: index.php");
    exit;
}

?>

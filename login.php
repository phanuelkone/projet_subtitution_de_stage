<?php
require_once 'Session.php';
require './vendor/autoload.php';
use App\Session;
use Firebase\JWT\JWT;

$session = new Session();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");

        // Configuration de PDO pour lancer des exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête pour récupérer l'id et le mot de passe haché
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");

        // Exécuter la requête en liant le paramètre :email
        $stmt->execute(['email' => $email]);

        // Récupérer la première ligne du résultat
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // Stocker les données de l'utilisateur dans la session
            $session->setCurrentUser($user);

            // Générer le JWT
            $payload = array(
                "user_id" => $user['id'],
                "exp" => time() + 7200 // Le token expire dans 2 heures
            );
            $jwt = JWT::encode($payload, "1234", 'HS256');

            // Enregistrer le JWT dans la base de données
            date_default_timezone_set('Europe/Paris');
            $expiry_time = date("Y-m-d H:i:s", time() + 7200);
            $stmt = $pdo->prepare("INSERT INTO user_sessions (user_id, token, expiry_time) VALUES (:user_id, :token, :expiry_time)");
            $stmt->bindParam(':user_id', $user['id']);
            $stmt->bindParam(':token', $jwt);
            $stmt->bindParam(':expiry_time', $expiry_time);
            $stmt->execute();



            // Stocker le JWT dans le cookie
            $session->setcookie("user_token", $jwt, time() + 7200, "/");

            // Rediriger vers la page d'accueil
            header('Location: deck_main.php');
            exit();
        } else {
            echo '<script>alert("Indentifiant incorrecte"); window.location.href = "index.php";</script>';
        }
    } catch (PDOException $e) {
        // Afficher les erreurs PDO
        echo "Erreur de connexion: " . $e->getMessage();
    }
}
?>

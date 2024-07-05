<?php
require_once 'Session.php';
use App\Session;

$session = new Session();
date_default_timezone_set('Europe/Paris');

// Vérifier si l'utilisateur est connecté
$isconnected = $session->isConnected();
$token_name = "user_token";

// Vérifier si le jeton est toujours valide
if ($isconnected && isset($_COOKIE[$token_name])) {
    $user_token = $_COOKIE[$token_name];

    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer l'ID de l'utilisateur actuel
        $userId = $session->getCurrentUserID();

        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupérer les données du formulaire
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_FILES['image'];

            // Gérer le téléchargement de l'image
            $imagePath = uniqid('', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

            // Vérifier si l'image est valide
            $check = getimagesize($image['tmp_name']);
            if($check === false) {
                echo "Le fichier n'est pas une image.";
                exit;
            }

            // Autoriser certains formats d'image seulement
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, $allowedTypes)) {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                exit;
            }

            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (!move_uploaded_file($image['tmp_name'], 'img/'.$imagePath)) {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                exit;
            }

            try {
                // Préparer la requête d'insertion avec des paramètres nommés
                $stmt = $pdo->prepare("INSERT INTO deck (nom, description, id_user, image) VALUES (:title, :description, :id_user, :image)");

                // Liaison des valeurs des paramètres nommés
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);

                $stmt->execute();

                // Afficher un message de réussite
                echo '<script>alert("Deck créé avec succès"); window.location.href = "deck_main.php";</script>';
            } catch (PDOException $e) {
                // Afficher les erreurs PDO
                echo "Erreur lors de la création du deck : " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>

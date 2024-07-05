<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");

        // Configuration de PDO pour lancer des exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion avec des paramètres nommés
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

        // Liaison des valeurs des paramètres nommés
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        // Exécuter la requête
        $stmt->execute();

        // Redirection vers la page de connexion après une inscription réussie
        header('Location: index.php');
        exit(); // Terminer l'exécution du script après la redirection
    } catch (PDOException $e) {
        // Afficher les erreurs PDO
        echo "Erreur lors de l'inscription: " . $e->getMessage();
    }
}
?>

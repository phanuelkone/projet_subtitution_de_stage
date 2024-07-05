<?php
require_once('functions.php');
?>

<?php
require_once('_head.php');
?>

<?php
// confirmation.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    var_dump($product_id);
    // Connexion à la base de données
    $bdd = connect();

    try {
        // Code pour traiter l'achat, par exemple enregistrer la transaction dans la base de données
        $sql = "INSERT INTO deck (id_prod) 
                SELECT produit.id_produit
                FROM produit 
                WHERE produit.id_produit = :id_prod";
        
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':id_prod', $product_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        echo "Transaction réussie.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

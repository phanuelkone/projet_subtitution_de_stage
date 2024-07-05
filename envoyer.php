
<?php




require_once('functions.php');

if (isset($_POST["envoyer"])) {
    $bdd = connect();
    

    $sql = "INSERT INTO messagerie (`email`, `message`,`nom`,`sujet`) VALUES (:email, :message ,:nom,:sujet);";
    ;
    $sth = $bdd->prepare($sql);
    if (!$sth) {
        die("Error during prepare: " . $bdd->errorInfo()[2]);
    }


    $success = $sth->execute([
        'email'     => $_POST['email'],
        'message'     => $_POST['message'],
        'nom'     => $_POST['nom'],
        'sujet'     => $_POST['sujet'],

    ]);if (!$success) {
        die("Error during execute: " . $sth->errorInfo()[2]);
    }

    header('Location: login.php');
    
}
?>
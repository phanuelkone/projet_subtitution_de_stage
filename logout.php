<?php
require_once 'Session.php';
require './vendor/autoload.php';
use App\Session;
use Firebase\JWT\JWT;

$session = new Session();

// Détruire le cookie
$session->setcookie("user_token", "", time() - 3600, "/");

// Détruire la session
$session->destroy();

// Rediriger vers la page de connexion
header('Location: index.php');
exit();
?>

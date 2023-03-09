<?php
// J'ai ajouté ce fichier, il a pour but de pouvoir configurer sa base de données et de s'y connecter.
// On s'en servira lorsqu'il faudra ajouter les récapitulatifs des parties à la bdd. (Quand une partie se termine)

// Paramètres de la base de données
$dbhost = 'localhost';
$dbname = 'partiespuissance4';
$dbuser = 'root';
$dbpass = '';

$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // affiche les erreurs sous forme d'exceptions
);

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, $options);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
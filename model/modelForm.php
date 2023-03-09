<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récolte des données du formulaire
    $j1 = $_POST['j1'] ?? '';
    $j2 = $_POST['j2'] ?? '';
    $j1Color = $_POST['j1Color'];
    $j2Color = $_POST['j2Color'];

    // Validation des données du formulaire
    if (empty($j1) || empty($j2) || $j1 == $j2 ) {
        $error_message = "Tous les joueurs doivent avoir un nom différent !";
    } elseif ($j1Color == $j2Color) {
        $error_message = "Les deux joueurs ne peuvent pas avoir la même couleur !";
    } else {
        // Si tt est ok, on envoie les données dans les variables de la session
        $_SESSION['j1'] = $j1;
        $_SESSION['j2'] = $j2;
        $_SESSION['j1Color'] = $j1Color;
        $_SESSION['j2Color'] = $j2Color;

        // Et on redirige sur la page de gestion de la partie
        header('Location: /EC1PHP_22202208/controller/Partie.php');
        exit();
    }
}
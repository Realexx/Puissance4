<?php
// j'ai ajouté ce fichier, qui permet de faire le lien entre le modèle et la vue d'une partie de jeu.

require('../model/modelPartie.php'); // Appel du modèle pour disposer des données et des fonctions les manipulant.

// Si le plateau de jeu n'existe pas, il faut initialiser le jeu
if (!isset($_SESSION['Board'])) InitGame();

// SI on n'a pas encore de gagnant (ou que la partie n'est pas nulle)
// ALORS On regarde si on a une requête GET, et si c'est le cas, on place une pièce en fonction la colonne récoltée par la requête GET.
// Le joueur qui place le pion dépend de la variable de SESSION $playerTurn
if (!isset($_SESSION['LineLastStroke']) && !isset($_SESSION['ColumnLastStroke']) || !YouWin()) {
    if (isset($_GET['col'])) {
        DropPiece($_SESSION['PlayerTurn'], $_GET['col']);
    }
}

require('../view/viewPartie.php'); // Affichage VUE




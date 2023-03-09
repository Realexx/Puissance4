<?php
require('../model/modelPartie.php');

if (!isset($_SESSION['Board'])) InitGame();

// Pour éviter les erreurs lorsque $LineLastStroke et $ColumnLastStroke n'existe pas
if (!isset($_SESSION['LineLastStroke']) && !isset($_SESSION['ColumnLastStroke'])) {
    if (isset($_GET['col'])) {
        DropPiece($_SESSION['PlayerTurn'], $_GET['col']);

        unset($_GET['col']);
    }
} else if (!YouWin()) {
    if (isset($_GET['col'])) {
        DropPiece($_SESSION['PlayerTurn'], $_GET['col']);

        unset($_GET['col']);
    }
}


require('../view/viewPartie.php');




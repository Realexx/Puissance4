<?php
// Ajout de ce fichier qui contient les fonctions du jeu/la partie.
// Les fonctions sont documentées.

session_start();

/**
 * Fonction qui initialise une partie de jeu. Notamment en définissant le tableau 2D (Board) et le joueur qui doit jouer (PlayerTurn).
 * @param int $nLines Nombre de lignes du plateau de jeu
 * @param int $nColumns Nombre de colonnes du plateau de jeu
 * @return void
 */
function InitGame(int $nLines = 6, int $nColumns = 7) {
    $_SESSION['PlayerTurn'] = $_SESSION['j1']; // Premier joueur à jouer ==> j1
    $_SESSION['Board'] = array();

    // Remplissage de $_SESSION['Board'] avec des chaines de caractères vides
    for ($i = 0; $i < $nLines; $i++) {
        $_SESSION['Board'][$i] = array();
        for ($j = 0; $j < $nColumns; $j++) {
            $_SESSION['Board'][$i][$j] = "";
        }
    }
}

/**
 * @return bool Le dernier joueur à avoir posé est-il vainqueur ?
 */
function YouWin(): bool {
    $width = count($_SESSION['Board'][0]);
    $height = count($_SESSION['Board']);

    // Var $actualPlayer qui contient le dernier joueur à avoir joué.
    $actualPlayer = "";
    if (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j1']) $actualPlayer = $_SESSION['j2'];
    elseif (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j2']) $actualPlayer = $_SESSION['j1'];

    // Check de la LIGNE sur laquelle le dernier pion a été posé
    $count = 0;
    for ($c = 0; $c < $width; $c++) {
        if ($_SESSION['Board'][$_SESSION['LineLastStroke']][$c] == $actualPlayer) {
            $count++;
        } else {
            $count = 0;
        }
        if ($count === 4) {
            return true;
        }
    }

    // Check de la COLONNE sur laquelle le dernier pion a été posé
    $count = 0;
    for ($l = 0; $l < $height; $l++) {
        if ($_SESSION['Board'][$l][$_SESSION['ColumnLastStroke']] == $actualPlayer) {
            $count++;
        } else {
            $count = 0;
        }
        if ($count === 4) {
            return true;
        }
    }

    // Check DIAG HAUT-GAUCHE -> BAS-DROITE
    $count = 0;
    for ($i = -3; $i <= 3; $i++) {
        $line = $_SESSION['LineLastStroke'] + $i;
        $col = $_SESSION['ColumnLastStroke'] + $i;
        if ($line < 0 || $col < 0 || $line >= $height || $col >= $width) {
            continue;
        }
        if ($_SESSION['Board'][$line][$col] == $actualPlayer) {
            $count++;
            if ($count === 4) {
                return true;
            }
        } else {
            $count = 0;
        }
    }

    // Check DIAG BAS-GAUCHE -> HAUT-DROITE
    $count = 0;
    for ($i = -3; $i <= 3; $i++) {
        $line = $_SESSION['LineLastStroke'] - $i;
        $col = $_SESSION['ColumnLastStroke'] + $i;
        if ($line < 0 || $col < 0 || $line >= $height || $col >= $width) {
            continue;
        }
        if ($_SESSION['Board'][$line][$col] == $actualPlayer) {
            $count++;
            if ($count === 4) {
                return true;
            }
        } else {
            $count = 0;
        }
    }
    return false;

}

/**
 * Ajoute les pions au plateau.
 * @param string $player Joueur qui place le pion
 * @param int $col Colonne dans laquelle est placé le pion
 * @return void
 */
function DropPiece(string $player, int $col) {
    $nb_lignes = count($_SESSION['Board']);

    // On parcourt la colonne (sur laquelle on veut poser le pion) dans le sens inverse, si la case contient la chaine "",
    // cela signifie qu'elle est vide, et on peut donc y poser le pion.
    for ($i = $nb_lignes-1; $i >= 0; --$i) {
        if ($_SESSION['Board'][$i][$col] == "") {
            $_SESSION['Board'][$i][$col] = $player;
            break;
        }
    }
    // Enregistrement du coup dans les variables du dernier coup joué.
    $_SESSION['LineLastStroke'] = $i;
    $_SESSION['ColumnLastStroke'] = $col;

    // Mise à jour du joueur qui doit jouer le prochain coup.
    if ($_SESSION['PlayerTurn'] == $_SESSION['j1']) {
        $_SESSION['PlayerTurn'] = $_SESSION['j2'];
    } else if ($_SESSION['PlayerTurn'] == $_SESSION['j2']) {
        $_SESSION['PlayerTurn'] = $_SESSION['j1'];
    }

    // Si en posant on a un gagnant, on le note, et on enregistre le récapitulatif de la partie dans la bdd
    if (YouWin()) {
        $winner = "";
        if ($_SESSION['PlayerTurn'] == $_SESSION['j1']) {
            $winner = $_SESSION['j2'];
        } else if ($_SESSION['PlayerTurn'] == $_SESSION['j2']) {
            $winner = $_SESSION['j1'];
        }

        $_SESSION['winner'] = $winner;

        // Enregistrement BDD
        require '../config/db.php';
        $sql = "INSERT INTO partie SET j1 = :j1, j2 = :j2, winner = :winner, board = :board";
        $req = $db->prepare($sql);
        $req->execute(array(
            ':j1' => $_SESSION['j1'],
            ':j2' => $_SESSION['j2'],
            ':winner' => $_SESSION['winner'],
            ':board' => serialize($_SESSION['Board'])
        ));

    } elseif (!YouWin()) { // Si on a pas de gagnant :
        if (checkIsBoardFull()) { // Il se peut que la partie soit nulle
            $_SESSION['winner'] = ""; // Gagnant = personne ==> ""

            // Enregistrement BDD
            require '../config/db.php';
            $sql = "INSERT INTO partie SET j1 = :j1, j2 = :j2, winner = :winner, board = :board";
            $req = $db->prepare($sql);
            $req->execute(array(
                ':j1' => $_SESSION['j1'],
                ':j2' => $_SESSION['j2'],
                ':winner' => $_SESSION['winner'],
                ':board' => serialize($_SESSION['Board'])
            ));
        }

    }
}

/**
 * Utilisé dans la fonction 'DropPiece' pour contrôler si le tableau est plein après avoir joué un pion.
 * @return bool Est-ce que le Plateau (tableau 2D) stocké dans la variable session est plein ?
 */
function checkIsBoardFull(): bool {
    $isDraw = true;

    foreach ($_SESSION['Board'] as $line) {
        foreach ($line as $value) {
            if (empty($value)) {
                $isDraw = false;
                break 2;
            }
        }
    }
    return $isDraw;

}





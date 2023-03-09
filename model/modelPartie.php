<?php
session_start();

function InitGame($nLines = 6, $nColumns = 7) {
    $_SESSION['PlayerTurn'] = $_SESSION['j1'];
    $_SESSION['Board'] = array();

    for ($i = 0; $i < $nLines; $i++) {
        $_SESSION['Board'][$i] = array();
        for ($j = 0; $j < $nColumns; $j++) {
            $_SESSION['Board'][$i][$j] = "";
        }
    }
}

function YouWin(): bool {
    $width = count($_SESSION['Board'][0]);
    $height = count($_SESSION['Board']);
    $actualPlayer = "";
    if (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j1']) $actualPlayer = $_SESSION['j2'];
    elseif (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j2']) $actualPlayer = $_SESSION['j1'];

    // Check Line
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

    // Check Col
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

    // Check Diag TOP-LEFT -> BOTTOM-RIGHT
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

    // Check Diag BOTTOM-LEFT -> TOP-RIGHT
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

function DropPiece($player, $col) {
    $nb_lignes = count($_SESSION['Board']);
    for ($i = $nb_lignes-1; $i >= 0; --$i) {
        if ($_SESSION['Board'][$i][$col] == "") {
            $_SESSION['Board'][$i][$col] = $player;
            break;
        }
    }
    $_SESSION['LineLastStroke'] = $i;
    $_SESSION['ColumnLastStroke'] = $col;

    if ($_SESSION['PlayerTurn'] == $_SESSION['j1']) {
        $_SESSION['PlayerTurn'] = $_SESSION['j2'];
    } else if ($_SESSION['PlayerTurn'] == $_SESSION['j2']) {
        $_SESSION['PlayerTurn'] = $_SESSION['j1'];
    }

    if (YouWin()) {
        $winner = "";
        if ($_SESSION['PlayerTurn'] == $_SESSION['j1']) {
            $winner = $_SESSION['j2'];
        } else if ($_SESSION['PlayerTurn'] == $_SESSION['j2']) {
            $winner = $_SESSION['j1'];
        }

        unset($_SESSION['PlayerTurn']);
        $_SESSION['winner'] = $winner;

        require '../config/db.php';
        $sql = "INSERT INTO partie SET j1 = :j1, j2 = :j2, winner = :winner, board = :board";
        $req = $db->prepare($sql);
        $req->execute(array(
            ':j1' => $_SESSION['j1'],
            ':j2' => $_SESSION['j2'],
            ':winner' => $_SESSION['winner'],
            ':board' => serialize($_SESSION['Board'])
        ));
    } elseif (!YouWin()) {
        if (checkIsDraw()) {
            $_SESSION['winner'] = "";
            unset($_SESSION['PlayerTurn']);

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

function checkIsDraw(): bool {
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





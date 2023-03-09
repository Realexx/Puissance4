<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jouer</title>
    <link rel="stylesheet" href="/view/css/style.css">
</head>
<body>


    <div class="player" <?php if (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j1']): ?> style="background-color: yellowgreen" <?php endif; ?> >
        <span class="player-color"
              style="background-color: <?php echo $_SESSION['j1Color'] ?>">  </span> <?php echo $_SESSION['j1']; ?>
    </div>
    <div class="player" <?php if (isset($_SESSION['PlayerTurn']) && $_SESSION['PlayerTurn'] == $_SESSION['j2']): ?> style="background-color: yellowgreen" <?php endif; ?>>
        <span class="player-color"
              style="background-color: <?php echo $_SESSION['j2Color'] ?>">  </span> <?php echo $_SESSION['j2'] ?></div>

    <table>
        <?php
        foreach ($_SESSION['Board'] as $i => $ligne) : ?>
            <tr>
                <?php foreach ($ligne as $j => $cellule) : ?>
                    <td><a href='<?php if ($cellule == "")
                            echo '/EC1PHP_22202208/controller/Partie.php?col=' . $j;
                        else echo '/EC1PHP_22202208/controller/Partie.php' ?>'
                           style="<?php if (!empty($cellule) && $cellule == $_SESSION['j1']) echo 'background-color: ' . $_SESSION['j1Color'] . ';';
                           elseif (!empty($cellule) && $cellule == $_SESSION['j2']) echo 'background-color: ' . $_SESSION['j2Color'] . ';' ?>"
                        >
                        </a></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <a class="destruct" href="/EC1PHP_22202208/Index.php?reset=true"> Détruire la partie </a>

    <?php if (isset($_SESSION['winner']) && !empty($_SESSION['winner'])) : ?>
        <p> La partie est terminé, le gagnant est : <strong><?= $_SESSION['winner'] ?></strong> ! </p>
        <p> Le récapitulatif de la partie a été enregistré.</p>
    <?php elseif (isset($_SESSION['winner']) && $_SESSION['winner'] == "") : ?>
        <p> La partie est terminé, <strong>c'est un match nul</strong> ! </p>
        <p> Le récapitulatif de la partie a été enregistré.</p>
    <?php endif; ?>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jouer</title>
    <link rel="stylesheet" href="/view/css/style.css">
</head>
<body>
<h1> Démarrer une partie </h1>
<form action="/EC1PHP_22202208/Index.php/" method="post">
    <label for="j1">Joueur 1 :</label>
    <input type="text" name="j1" id="j1" placeholder="Nom du joueur" value="<?php if (isset($_POST['j1'])) echo $_POST['j1']; ?>">
    <input type="color" name="j1Color" id="j1Color" value="<?php if (isset($_POST['j1Color'])) echo $_POST['j1Color']; ?>"><br>

    <label for="j2">Joueur 2 :</label>
    <input type="text" name="j2" id="j2" placeholder="Nom du joueur" value="<?php if (isset($_POST['j2'])) echo $_POST['j2']; ?>">
    <input type="color" name="j2Color" id="j2Color" value="<?php if (isset($_POST['j2Color'])) echo $_POST['j2Color']; ?>"><br>
    <button type="submit">Jouer</button>
    <?php if (isset($_SESSION['Board'])): ?>
        <strong style="font-family: sans-serif"> OU </strong>
        <a class="resume" href="/EC1PHP_22202208/controller/Partie.php">Reprendre la partie en cours !</a>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
    <?php endif; ?>

</form>

</body>
</html>



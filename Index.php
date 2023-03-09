<?php

// Dans ce fichier, on remarque que j'ai essayé de séparer au plus les choses.
// Appel du modèle puis de la vue.
// Si on accède à cet index avec le lien : "Index.php?reset='ANY'" on détruit toutes les informations de la session et on en relance une.

require('model/modelForm.php');

if (isset($_GET['reset'])) {
    session_unset();
    session_destroy();
    session_start();
}

require('view/viewForm.php');
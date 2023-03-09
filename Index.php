<?php

require('model/modelForm.php');

if (isset($_GET['reset'])) {
    session_unset();
    session_destroy();
    session_start();
}

require('view/viewForm.php');
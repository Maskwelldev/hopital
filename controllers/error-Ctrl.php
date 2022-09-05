<?php

require_once __DIR__.'/../config/config.php';

$error = intval(filter_input(INPUT_GET, 'error', FILTER_SANITIZE_NUMBER_INT));

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
    include(__DIR__ . '/../views/error.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
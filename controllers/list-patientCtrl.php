<?php
require_once(dirname(__FILE__) . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');

// Appel à la méthode statique permettant de récupérer tous les patients
$patients = Patient::getAll();
/*************************************************************/

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php'); 
include(__DIR__ . '/../views/patients/list-patients.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
<?php
include(__DIR__ . '/../models/Patient.php');
include(__DIR__ . '/../models/Doctor.php');

$countPatients = Patient::getCount();
$countDoctors = Doctor::getCount();


/* ************* AFFICHAGE DES VUES **************************/
include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php');  
include(__DIR__ . '/../home.php');  
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
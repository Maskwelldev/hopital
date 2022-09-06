<?php

require_once(__DIR__ . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');
require_once(__DIR__ . '/../models/Appointment.php');

$appointments = Appointment::getAll();
// $appointments = Appointment:: getServices();
// var_dump($appointments);die;
if(isset($_POST['search'])){
    $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
    $appointments = Appointment::search($search);
    
    
}

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php'); 
include(__DIR__ . '/../views/appointments/list-appointments.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
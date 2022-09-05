<?php

require_once(__DIR__ . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');
require_once(__DIR__ . '/../models/Appointment.php');

$appointments = Appointment::getAll();

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php'); 
include(__DIR__ . '/../views/appointments/list-appointments.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
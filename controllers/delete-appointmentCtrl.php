<?php

require_once(dirname(__FILE__) . '/../helpers/SessionFlash.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

// Nettoyage de l'id du rendez-vouspassé en GET dans l'url
$id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
/*********************************************************/

$isDeleted = Appointment::delete($id);

if($isDeleted === true){
    SessionFlash::setMessage('Le rdv a bien été supprimé');
} else {
    SessionFlash::setMessage('Une erreur s\'est produite lors de la suppression du rdv.');
}

header('Location: '.$_SERVER['HTTP_REFERER']);
die();
<?php
require_once(__DIR__ . '/../models/Patient.php');
require_once(__DIR__ . '/../models/Appointment.php');
require_once(__DIR__ . '/../config/regexp.php');

// Nettoyage de l'id du rdv passé en GET dans l'url
$id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
/*************************************************************/

// Appel à la méthode statique permettant de récupérer toutes les infos d'un rdv
$appointmentObj = Appointment::get($id);

// Si $appointmentObj est false,
// on stocke un message d'erreur à afficher dans la vue
if ($appointmentObj === false) {
    $errors['global'] = ERRORS[8];
} else {
    // Appel à la méthode statique permettant de récupérer tous les patients pour le select
    $allPatients = Patient::getAll();
    /*************************************************************/

    //On ne controle que s'il y a des données envoyées 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // DATE ET HEURE DE RDV
        // On verifie l'existance et on nettoie
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS));

        //On teste si le champ est vide
        if (empty($date)) {
            $errors['date_error'] = 'Le champ est obligatoire';
        } else {
            // On teste la valeur
            $isOk = filter_var($date, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXP_DATE_HOUR . '/')));
            if (!$isOk) {
                $errors['date_error'] = 'La date n\'est pas valide, le format attendu est JJ/MM/AAAA';
            }
        }

        // Récupération des heures et des minutes avec formatage sur 2 chiffres
        $hour = sprintf("%02d", intval(filter_input(INPUT_POST, 'hour', FILTER_SANITIZE_NUMBER_INT)));
        $min = sprintf("%02d", intval(filter_input(INPUT_POST, 'min', FILTER_SANITIZE_NUMBER_INT)));

        //On teste si les champs sont vides
        if (empty($hour) || empty($min)) {
            $errors['dateHour_error'] = 'Vous devez choisir une heure de rdv';
        }

        if (empty($errors)) {
            $dateHour = $date . ' ' . $hour . ':' . $min;
        }
        // ***************************************************************

        $idPatients = intval(trim(filter_input(INPUT_POST, 'idPatients', FILTER_SANITIZE_NUMBER_INT)));
        //On test si le champ n'est pas vide
        if ($idPatients == 0) {
            $errors['idPatients_error'] = ERRORS[2];
        }

        // Si il n'y a pas d'erreurs, on met à jour le rdv.
        if (empty($errors)) {
            // On hydrate l'objet appointment en effectuant une instance de la classe Appointment
            $appointment = new Appointment();
            $appointment->setDateHour($dateHour);
            $appointment->setIdPatients($idPatients);

            // Si la réponse de la méthode update est false,
            // on stocke un message d'erreur à afficher dans la vue
            var_dump("hkjhkjh");
            if(!$appointment->update($id)){
                $errors['global'] = ERRORS[10];
            } else {
                $errors['global'] = MESSAGES[3];
            }
            // On récupère à nouveau les infos du rdv suite à la mise à jour
            $appointmentObj = Appointment::get($id);
        }
    }
}
/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php');
include(__DIR__ . '/../views/appointments/form-appointment.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/

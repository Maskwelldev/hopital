<?php
include(__DIR__ . '/../config/regexp.php');
include(__DIR__ . '/../models/Patient.php');
include(__DIR__ . '/../models/Appointment.php');
include(__DIR__ . '/../models/Doctor.php');
$who = 'rendez-vous';


// Appel à la méthode statique permettant de récupérer tous les patients
$allPatients = Patient::getAll();
$allDoctors = Doctor::getAll();
/*************************************************************/

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // DATE ET HEURE DE RDV
    // On verifie l'existance et on nettoie
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS));
    
    //On teste si le champ est vide
    if(empty($date)){
        $errors['date_error'] = 'Le champ est obligatoire';
    }else{
        // On teste la valeur
        $isOk = filter_var($date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEXP_DATE_HOUR.'/')));
        if(!$isOk){
            $errors['date_error'] = 'La date n\'est pas valide, le format attendu est JJ/MM/AAAA';
        }
    }

    // Récupération des heures et des minutes avec formatage sur 2 chiffres
    $hour = sprintf("%02d", intval(filter_input(INPUT_POST, 'hour', FILTER_SANITIZE_NUMBER_INT)));
    $min = sprintf("%02d", intval(filter_input(INPUT_POST, 'min', FILTER_SANITIZE_NUMBER_INT)));

    //On teste si les champs sont vides
    if(empty($hour) || empty($min)){
        $errors['dateHour_error'] = 'Vous devez choisir une heure de rdv';
    }

    if(empty($errors)){
        $dateHour = $date . ' ' . $hour . ':' . $min;
    }
    // ***************************************************************


    $idPatients = intval(trim(filter_input(INPUT_POST, 'idPatients', FILTER_SANITIZE_NUMBER_INT)));
    //On test si le champ est vide
    if($idPatients==0){
        $errors['dateHour_error'] = 'Le champ est obligatoire';
    }
    $idDoctor = intval(trim(filter_input(INPUT_POST, 'idDoctor', FILTER_SANITIZE_NUMBER_INT)));
    //On test si le champ est vide
    if($idDoctor==0){
        $errors['dateHour_error'] = 'Le champ est obligatoire';
    }

    // Si il n'y a pas d'erreurs, on enregistre un nouveau rdv.
    if(empty($errors) ){
        // On hydrate l'objet appointment en effectuant une instance de la classe Appointment
        $appointment = new Appointment();
        $appointment->setDateHour($dateHour);
        $appointment->setIdPatients($idPatients);
        $appointment->setIdDoctor($idDoctor);
        
        // Si la réponse de la méthode save est false,
        // on stocke un message d'erreur à afficher dans la vue
        
        if(!$appointment->save()){
            $errors['global'] = ERRORS[7];
        } else {
            $errors['global'] = MESSAGES[2];
        }
        /*************************************************************/
    }

}

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php');
include(__DIR__ . '/../views/appointments/form-appointment.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
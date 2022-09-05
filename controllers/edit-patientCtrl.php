<?php
require_once(__DIR__ . '/../config/regexp.php');
require_once(__DIR__ . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');
require_once(__DIR__ . '/../models/Appointment.php');

// Nettoyage de l'id passé en GET dans l'url
$id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
/*************************************************************/

$patient = Patient::get($id);

// Si $patient vaut false,
// on stocke un message d'erreur à afficher dans la vue
if ($patient === false) {
    $errors['global'] = ERRORS[3];
} else {
    //On ne controle que s'il y a des données envoyées 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        /************************* LASTNAME *************************/
        //**** NETTOYAGE ****/
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        //**** VERIFICATION ****/
        if (empty($lastname)) {
            $errors['lastname'] = 'Le champ est obligatoire';
        } else {
            $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXP_STR_NO_NUMBER . '/')));
            if (!$isOk) {
                $errors['lastname'] = 'Merci de choisir un nom valide';
            }
        }
        /***********************************************************/


        /************************* FIRSTNAME ***********************/
        //**** NETTOYAGE ****/
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        //**** VERIFICATION ****/
        if (empty($firstname)) {
            $errors['firstname'] = 'Le champ est obligatoire';
        } else {
            $isOk = filter_var($firstname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXP_STR_NO_NUMBER . '/')));
            if (!$isOk) {
                $errors['firstname'] = 'Le prénom n\'est pas valide';
            }
        }
        /***********************************************************/


        /************************ BIRTHDATE ************************/
        //**** NETTOYAGE ****/
        $birthdate = trim(filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        //**** VERIFICATION ****/
        if (empty($birthdate)) {
            $errors['birthdate'] = 'Le champ est obligatoire';
        } else {
            $isOk = filter_var($birthdate, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXP_DATE . '/')));
            if (!$isOk) {
                $errors['birthdate'] = 'Le date n\'est pas valide, le format attendu est JJ/MM/AAAA';
            }
        }
        /***********************************************************/


        /************************** PHONE **************************/
        //**** NETTOYAGE ****/

        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        //**** VERIFICATION ****/
        if (!empty($phone)) {
            $isOk = filter_var($phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXP_PHONE . '/')));
            if (!$isOk) {
                $errors['phone'] = 'Le numero n\'est pas valide, les séparateur sont - . /';
            }
        }
        /***********************************************************/


        /*************************** MAIL **************************/
        //**** NETTOYAGE ****/
        $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL));

        //**** VERIFICATION ****/
        if (empty($mail)) {
            $errors['mail'] = 'Le champ est obligatoire';
        } else {
            $isOk = filter_var($mail, FILTER_VALIDATE_EMAIL);
            if (!$isOk) {
                $errors['mail'] = 'Le mail n\'est pas valide';
            }
            // Si le mail de l'input est nouveau ET qu'il existe déjà en bdd, --> Erreur
            if ($mail != $patient->mail && Patient::isMailExists($mail)) {
                $errors['mail'] = ERRORS[5];
            }
        }
        /***********************************************************/

        // Si il n'y a pas d'erreurs, on met à jour le patient.
        if (empty($errors)) {
            
            //**** HYDRATATION ****/
            $patient = new Patient;
            $patient->setLastname($lastname);
            $patient->setFirstname($firstname);
            $patient->setBirthdate($birthdate);
            $patient->setPhone($phone);
            $patient->setMail($mail);
            $patient = $patient->update($id);

            if($patient){
                $errors['global'] = MESSAGES[1];
            } else {
                $errors['global'] = ERRORS[4];
            }    
        }
    }
}
// On récupère les données du patient et des rdvs mis à jour
$patient = Patient::get($id);
$appointments = Appointment::getAll($id);

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php'); 

    include(__DIR__ . '/../views/patients/form-patient.php');
    include(__DIR__ . '/../views/appointments/list-appointments.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/

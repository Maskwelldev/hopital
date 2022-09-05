<?php
require_once(dirname(__FILE__) . '/../helpers/SessionFlash.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');

// Nettoyage de l'id du patient passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*********************************************************/

// Suppression du patient, et de tous ses rendez-vous. 
// Une contrainte ON DELETE CASCADE, permet de supprimer tous les enregistrements 
// de la table A et tous les éléments de la table B possédant une clé etrangère

$result = Patient::delete($id);
if ($result === true){
    SessionFlash::setMessage('Le patient a bien été supprimé');
} else {
    SessionFlash::setMessage('Un problème est survenu lors de la suppression du patient');
}

header('Location: '.$_SERVER['HTTP_REFERER']);
exit();
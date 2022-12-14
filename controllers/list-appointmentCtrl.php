<?php
require_once(__DIR__ . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');
require_once(__DIR__ . '/../models/Appointment.php');
$who = 'rendez-vous';

$appointments = Appointment::getAll();
// $appointments = Appointment:: getServices();
// var_dump($appointments);die;
if(isset($_POST['search'])){
    $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
}
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
}
$search = $_POST['search'] ?? '';
$patients = Patient::getCountAll($search);
if(isset($_GET['page']) && !empty($_GET['page'])){
$currentPage = (int) strip_tags($_GET['page']);
} else {
// var_dump(true);die;
$currentPage = 1;
}

if($result = Appointment::getCountAll($search)){
// var_dump($result->count);die;

$nbArticles = $result->count;
// Détermine le nombre d'articles par page
$perPage = 10;
// Calcule le nombre total de pages
$pages = ceil($nbArticles / $perPage);
// var_dump($pages);die;
// Calcul du 1er article de la page
$premier = ($currentPage * $perPage) - $perPage;
// var_dump($premier);die;
$appointments = Appointment::getPerPage($premier, $perPage, $search);

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php'); 
include(__DIR__ . '/../views/appointments/list-appointments.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/

}
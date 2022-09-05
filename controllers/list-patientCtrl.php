<?php
require_once(dirname(__FILE__) . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../models/Patient.php');

// Appel à la méthode statique permettant de récupérer tous les patients
$patients = Patient::getAll();
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    // var_dump(true);die;
    $currentPage = 1;
}

if($result = Patient::getCount()){
    
$nbArticles = $result->count;
// var_dump($nbArticles);die;
// Détermine le nombre d'articles par page
$perPage = 10;
// Calcule le nombre total de pages
$pages = ceil($nbArticles / $perPage);
// Calcul du 1er article de la page
$premier = ($currentPage * $perPage) - $perPage;
// var_dump($premier);die;

$results = Patient::getPerPage($premier, $perPage);
// var_dump($patient);die;	


// if (isset($_POST['search']) && !empty($_POST['search'])) {
//     $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
//     $patients = Patient::search($search);

    
// }

/*************************************************************/

/* ************* AFFICHAGE DES VUES **************************/

include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php');
include(__DIR__ . '/../views/patients/list-patients.php');
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/
}
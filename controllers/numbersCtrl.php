<?php
include(__DIR__ . '/../models/Service.php');
require_once(dirname(__FILE__) . '/../helpers/SessionFlash.php');
$who = 'numéro';

$services = Service::getAll();
// Appel à la méthode statique permettant de récupérer tous les patients
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
}
$search = $_POST['search'] ?? '';
$servicesPerPage = Service::getCountAll($search);
if(isset($_GET['page']) && !empty($_GET['page'])){
$currentPage = (int) strip_tags($_GET['page']);
} else {
// var_dump(true);die;
$currentPage = 1;
}

if($result = Service::getCountAll($search)){
// var_dump($result->count);die;

$nbArticles = $result->count;
// var_dump($nbArticles);die;
// Détermine le nombre d'articles par page
$perPage = 10;
// Calcule le nombre total de pages
$pages = ceil($nbArticles / $perPage);
// var_dump($pages);die;
// Calcul du 1er article de la page
$premier = ($currentPage * $perPage) - $perPage;
// var_dump($premier);die;
$results = Service::getPerPage($premier, $perPage, $search);
// var_dump($patient);die;	


/* ************* AFFICHAGE DES VUES **************************/
include(__DIR__ . '/../views/templates/header.php');
include(__DIR__ . '/../views/templates/nav.php');  
include(__DIR__ . '/../views/numbers/numbers.php');  
include(__DIR__ . '/../views/templates/footer.php');

/*************************************************************/

}
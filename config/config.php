<?php

define('DSN', 'mysql:host=localhost;dbname=hosto');
define('LOGIN', 'root');
define('PASSWORD', '');

define('ERRORS', [
    0=>'Une erreur inconnue s\'est produite',
    1=>'Problème de connexion à la BDD',
    2=>'Erreur lors de la récupération du patient',
    3=>'Patient non trouvé',
    4=>'Erreur lors de la mise à jour du patient',
    5=>'Patient non mis à jour, ce patient existe déjà',
    6=>'Erreur lors de la création du rendez-vous',
    7=>'Rendez-vous non créé',
    8=>'Erreur lors de la récupération du rendez-vous',
]);

define('MESSAGES', [
    1=>'Patient mis à jour',
    2=>'Le rendez-vous a été créé',
    3=>'Le rendez-vous a bien été mis à jour',
]);
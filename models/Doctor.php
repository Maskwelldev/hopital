<?php

require_once(__DIR__ . '/../helpers/database.php');

class Doctor
{

    private int $id;
    private string $name;
    private string $lastname;
    private object $pdo;

    /**
     * Constructeur appelé automatiquement à l'instanciation
     */
    public function __construct() {
        $this->pdo = Database::getInstance();
    }




/**
     * Compte le nombre de docteurs 
     * 
     * @param
     * 
     * @return boolean
     */

    public static function getCountAll()
    {
        try {
            $pdo = Database::getInstance();
            $sql = 'SELECT count(*) AS `count` FROM `doctors`;';
            $sth = $pdo->prepare($sql);
            $sth->execute();
            $count = $sth->fetch();
            return $count;
            // var_dump($count);die;
        } catch (PDOException $ex) {
            //var_dump($ex);
            return false;
        }
    }


    /**
     * Liste tous les patients existants
     * 
     * @return array
     */
    public static function getAll()
    {
        try {
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();

            // On créé la requête
            $sql = 'SELECT * FROM `doctors`';

            // On exécute la requête
            $sth = $pdo->query($sql);

            return $sth->fetchAll();

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }

/**
     * Retourne le nombre de docteurs 
     * 
     * @param
     * 
     * @return boolean
     */

    /**
     * Liste tous les patients existants
     * 
     * @return array
     */
    public static function getPerPage($premier, $perPage, $search, $pointVirgule = ';')
    {
        try {
            // var_dump($premier, $perPage);die;
            // On stocke une instance de la classe PDO dans une variable
            $search = $search ?? '';
            $pdo = Database::getInstance();
            // On créé la requête
            $sql = "SELECT * FROM `doctors`
                    INNER JOIN `specialities` ON `doctors`.`idSpeciality` = `specialities`.`id`
                    WHERE((`lname` LIKE :search) OR (`fname` LIKE :search) OR (`mail` LIKE :search))
                    LIMIT :premier, :perPage
                    $pointVirgule";     

            // On exécute la requête
            $sth = $pdo->prepare($sql);
            // On affecte chaque valeur à chaque marqueur nominatif
            $sth->bindValue(':premier', $premier, PDO::PARAM_INT);
            $sth->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            $sth->bindValue(':search', '%' . $search . '%',PDO::PARAM_STR);
            if($sth->execute()){
                // var_dump($sth->fetchAll(PDO::FETCH_OBJ));die;
            return $sth->fetchAll(PDO::FETCH_OBJ);
            } else return false;

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }

}
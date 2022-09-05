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

    public static function getCount()
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

}
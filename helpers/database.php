<?php

require_once __DIR__.'/../config/config.php';

class Database{

    public static function getInstance(){

        try{

            $pdo = new PDO(DSN, LOGIN, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        }
        catch(PDOException $ex){
            header('Location: /controllers/error-Ctrl.php?error=1');
        }

    }
}
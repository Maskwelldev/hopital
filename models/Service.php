<?php
require_once(__DIR__ . '/../helpers/database.php');

class Service
{

    private int $id;
    private string $service_name;
    private int $service_phone;
    private int $service_mail;

    private object $pdo;


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setServiceName(string $service_name): void
    {
        $this->service_name = $service_name;
    }

    public function getServiceName(): string
    {
        return $this->service_name;
    }

    public function setServicePhone(int $service_phone): void
    {
        $this->service_phone = $service_phone;
    }

    public function getServicePhone(): string
    {
        return $this->service_phone;
    }

    public function setServiceMail(int $service_mail): void
    {
        $this->service_mail = $service_mail;
    }

    public function getServiceMail(): string
    {
        return $this->service_mail;
    }

    /**
     * Méthode magique qui permet d'hydrater notre objet 'patient' avec la connexion PDO
     * 
     * @return boolean
     */
    public function __construct()
    {
        // Hydratation de l'objet contenant la connexion à la BDD
        $this->pdo = Database::getInstance();
    }


    /**
     * Retourne la table spécialités
     * 
     * @return boolean
     */
    public static function getAll()
    {
        try {
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();

            // On créé la requête
            $sql = 'SELECT * FROM `specialities`';

            // On exécute la requête
            $sth = $pdo->query($sql);

            return $sth->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }

    /**
     * Retourne le nombre de services
     * 
     * @return array
     */
    public static function getCountAll($search)
    {
        try {
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();

            // On créé la requête
            $sql = 'SELECT COUNT(*) AS `count` FROM `specialities` WHERE `specialities`.`service_name` LIKE :search;';

            // On exécute la requête
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':search', '%' . $search . '%',PDO::PARAM_STR);
            $sth->execute();    
            return $sth->fetch(PDO::FETCH_OBJ);

        } catch (PDOException $ex) {
            return [];
        }
    }

    /**
     * Liste tous les services
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
            $sql = "SELECT * FROM `specialities`
                    WHERE((`service_name` LIKE :search) OR (`service_mail` LIKE :search) OR (`service_phone` LIKE :search))
                    LIMIT :premier, :perPage
                    $pointVirgule";     

            // On exécute la requête
            $sth = $pdo->prepare($sql);
            // On affecte chaque valeur à chaque marqueur nominatif
            $sth->bindValue(':premier', $premier, PDO::PARAM_INT);
            $sth->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            $sth->bindValue(':search', '%' . $search . '%',PDO::PARAM_STR);
            if($sth->execute()){
            return $sth->fetchAll(PDO::FETCH_OBJ);
            } else return false;

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }

}



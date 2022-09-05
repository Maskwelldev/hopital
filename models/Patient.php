<?php

require_once(__DIR__ . '/../helpers/database.php');

class Patient
{

    private int $id;
    private string $firstname;
    private string $lastname;
    private string $birthdate;
    private string $phone;
    private string $mail;

    private object $pdo;

    /**
     * Constructeur appelé automatiquement à l'instanciation
     */
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    /**
     * @param int $id
     * 
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $firstname
     * 
     * @return void
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     * 
     * @return void
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $birthdate
     * 
     * @return void
     */
    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * @param string $phone
     * 
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $mail
     * 
     * @return void
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * 
     * Vérifie si un email est présent en bdd
     * 
     * @param string $mail
     * 
     * @return bool
     */
    public static function isMailExists(string $mail): bool
    {
        try {
            $sql = 'SELECT * FROM `patients` WHERE `mail` = :mail';

            $sth = Database::getInstance()->prepare($sql);
            $sth->bindValue(':mail', $mail, PDO::PARAM_STR);
            $sth->execute();

            return empty($sth->fetch()) ? false : true;

        } catch (\PDOException $ex) {
            //var_dump($ex);
            return false;
        }
    }

    /**
     * Crée un patient
     * 
     * @return boolean
     */
    public function insert(): bool
    {

        try {
            // On créé la requête avec des marqueurs nominatifs
            $sql = 'INSERT INTO `patients` (`lastname`, `firstname`, `birthdate`, `phone`, `mail`) 
                VALUES (:lastname, :firstname, :birthdate, :phone, :mail);';

            // On prépare la requête
            $sth = $this->pdo->prepare($sql);

            //Affectation des valeurs aux marqueurs nominatifs
            $sth->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->getFirstname(), PDO::PARAM_STR);
            $sth->bindValue(':birthdate', $this->getBirthdate(), PDO::PARAM_STR);
            $sth->bindValue(':phone', $this->getPhone(), PDO::PARAM_STR);
            $sth->bindValue(':mail', $this->getMail(), PDO::PARAM_STR);
            // On retourne directement true si la requête s'est bien exécutée ou false dans le cas contraire
            return $sth->execute();
        } catch (PDOException $ex) {
            //var_dump($ex);
            // On retourne false si une exception est levée
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
            $sql = 'SELECT * FROM `patients`';

            // On exécute la requête
            $sth = $pdo->query($sql);

            return $sth->fetchAll();

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }


    /**
     * Liste tous les patients existants
     * 
     * @return array
     */
    public static function getPerPage($premier, $perPage, $pointVirgule = ';')
    {
        try {
            // var_dump($premier, $perPage);die;
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();
            // On créé la requête
            $sql = "SELECT * FROM `patients`
                    LIMIT :premier, :perPage
                    $pointVirgule";     

            // On exécute la requête
            $sth = $pdo->prepare($sql);
            // On affecte chaque valeur à chaque marqueur nominatif
            $sth->bindValue(':premier', $premier, PDO::PARAM_INT);
            $sth->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            if($sth->execute()){
            return $sth->fetchAll(PDO::FETCH_OBJ);
            } else return false;

        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }


    /**
     * 
     * Récupère toutes les données du patient
     * @param int $id
     * @return mixed
     */
    public static function get(int $id): mixed
    {

        try {
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();

            // On créé la requête
            $sql = 'SELECT * FROM patients WHERE `id` = :id';

            // On prépare la requête
            $sth = $pdo->prepare($sql);

            // On affecte chaque valeur à chaque marqueur nominatif
            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            if ($sth->execute() === false) {
                //Erreur générale
                return false;
            } else {
                $patient = $sth->fetch();
                if ($patient === false) {
                    //Patient non trouvé
                    return false;
                } else {
                    return $patient;
                }
            }
        } catch (\PDOException $ex) {
            //var_dump($ex);
            return false;
        }
    }

    /**
     * Méthode qui permet de mettre à jour un patient
     * 
     * @param int $id
     * 
     * @return boolean
     */

    public function update(int $id): bool
    {
        try {

            $sql = 'UPDATE `patients` SET 
                        `lastname` = :lastname, 
                        `firstname` = :firstname, 
                        `birthdate` = :birthdate, 
                        `phone` = :phone, 
                        `mail` = :mail
                    WHERE `id` = :id';

            $sth = $this->pdo->prepare($sql);
            $sth->bindValue(':lastname', $this->getLastname());
            $sth->bindValue(':firstname', $this->getFirstname());
            $sth->bindValue(':birthdate', $this->getBirthdate());
            $sth->bindValue(':phone', $this->getPhone());
            $sth->bindValue(':mail', $this->getMail());
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            return $sth->execute();
           
        } catch (PDOException $ex) {
            //var_dump($ex);
            return false;
        }
    }
    
    
    /**
     * Compte le nombre de patients 
     * 
     * @param
     * 
     * @return
     */

    public static function getCount()
    {
        try {
            $pdo = Database::getInstance();
            $sql = 'SELECT count(*) AS `count` FROM `patients`;';
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

    public function getCountOfAnnouncements($type, $category, $search){
        try {
            if(!empty($type) || !empty($category) || !empty($search)){
                $conditions = null;
                if(!empty($type)){
                    $conditions = array();
                    array_push($conditions, "`id_type_of_announcement` = :type");
                }
                if(!empty($category)){
                    $conditions ? '' : $conditions = array();
                    array_push($conditions, "`id_category` = :category");
                }
                if(!empty($conditions)){
                    $conditions = ' WHERE ' . implode(' AND ', $conditions);
                }
                if(!empty($search)){
                    $searchVal = ' AND `announcements`.`announcement_description` LIKE :search;';
                }
            }

            $conditions = $conditions ?? '';
            $searchVal = $searchVal ?? '';
            $pdo = Database::dbConnect();
            $sql = "SELECT COUNT(*) AS nb_articles 
                    FROM `announcements` 
                    INNER JOIN `users` 
                    ON `announcements`.`id_user` = `users`.`id_user`
                    $conditions
                    $searchVal";
            $stmt = $pdo->prepare($sql);
            if(!empty($type)){
                $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            }
            if(!empty($category)){
                $stmt->bindValue(':category', $category, PDO::PARAM_INT);
            }
            if(!empty($search)){
                $stmt->bindValue(':search', "%".$search."%", PDO::PARAM_STR);
            }
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'erreur dans la requête' . $e->getMessage();
        }
    }


    /**
     * Liste tous les patients depuis le champs de recherche
     * 
     * @return array
     */
    public static function search(?string $search = '')
    {
        try {
            // On stocke une instance de la classe PDO dans une variable
            $pdo = Database::getInstance();
            // On créé la requête
            $sql = "SELECT `firstname`, `lastname`,`birthdate`, `phone`, `mail`, `id` 
            FROM `patients` 
            WHERE((`lastname` LIKE :search) OR (`firstname` LIKE :search) OR (`mail` LIKE :search));";
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':search', '%' . $search . '%',PDO::PARAM_STR);
            $sth->execute();

            // On exécute la requêt
            return $sth->fetchAll();
            
            
        } catch (PDOException $ex) {
            //var_dump($ex);
            return [];
        }
    }
    
}



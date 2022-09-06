<?php
require_once(__DIR__ . '/../helpers/database.php');

class Appointment
{

    private int $id;
    private string $dateHour;
    private int $idPatients;
    private int $idDoctor;

    private object $pdo;


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setDateHour(string $dateHour): void
    {
        $this->dateHour = $dateHour;
    }

    public function getDateHour(): string
    {
        return $this->dateHour;
    }

    public function setIdPatients(int $idPatients): void
    {
        $this->idPatients = $idPatients;
    }

    public function getIdPatients(): int
    {
        return $this->idPatients;
    }

    public function setIdDoctor(int $idDoctor): void
    {
        $this->idDoctor = $idDoctor;
    }

    public function getIdDoctor(): int
    {
        return $this->idDoctor;
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
     * Méthode qui permet de créer un rendez-vous
     * 
     * @return boolean
     */
    public function save(): bool
    {

        try {
            $sql = 'INSERT INTO `appointments` (`dateHour`, `idPatient`, `idDoctor`) 
                    VALUES (:dateHour, :idPatients, :idDoctor)';
            $sth = $this->pdo->prepare($sql);

            $sth->bindValue(':dateHour', $this->getDateHour(), PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->getIdPatients(), PDO::PARAM_INT);
            $sth->bindValue(':idDoctor', $this->getIdDoctor(), PDO::PARAM_INT);
            return $sth->execute();
        } catch (PDOException $ex) {
            // var_dump($ex);
            // On retourne false si une exception est levée
            return false;
        }
    }

    /**
     * Méthode qui permet de mettre à jour un rdv
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {

        try {
            $sql = 'UPDATE `appointments` SET `dateHour` = :dateHour, `idPatients` = :idPatients
                    WHERE `id` = :id';

            $sth = $this->pdo->prepare($sql);

            $sth->bindValue(':dateHour', $this->getDateHour(), PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->getIdPatients(), PDO::PARAM_INT);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            return $sth->execute();
        } catch (PDOException $ex) {
            // var_dump($ex);
            return false;
        }
    }

    /**
     * Méthode permettant de récupérer un rdv
     * @param int $id
     * 
     * @return object
     */
    public static function get(int $id)
    {

        try {
            $pdo = Database::getInstance();
            $sql = 'SELECT * FROM `appointments`
                    WHERE `appointments`.`id` = :id;';

            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            $result = $sth->execute();
            if ($result === false) {
                return false;
            } else {
                $appointment = $sth->fetch();
                if ($appointment === false) {
                    //Rdv non trouvé
                    return false;
                } else {
                    return $appointment;
                }
            }
        } catch (\PDOException $ex) {
            // var_dump($ex);
            return false;
        }
    }

    /**
     * Méthode qui permet de lister tous les rdv et leur patient
     * 
     * @return array
     */
    public static function getAll(): array
    {

        $pdo = Database::getInstance();

        try {
            $sql = '    SELECT `appointments`.`id` as `appointmentId`, `patients`.`id` as `patientId`, `patients`.*, `appointments`.* 
                        FROM `appointments` 
                        INNER JOIN `patients`
                        ON `appointments`.`idPatient` = `patients`.`id`
                        ORDER BY `appointments`.`dateHour` DESC
                        ;';
            $sth = $pdo->query($sql);

            if ($sth === false) {
                return [];
            } else {
                return $sth->fetchAll();
            }
        } catch (PDOException $ex) {
            // var_dump($ex);
            // On retourne false si une exception est levée
            return [];
        }
    }


    /**
     * Méthode qui permet de lister les deux prochains rendez-vous
     * 
     * @return array
     */
    public static function getTwice()
    {

        $pdo = Database::getInstance();

        try {
            $sql = 'SELECT * FROM `appointments` 
                    INNER JOIN `patients`
                    ON `appointments`.`idPatient` = `patients`.`id`
                    ORDER BY `appointments`.`dateHour` DESC
                    LIMIT 2;';
            $sth = $pdo->query($sql);
            if ($sth === false) {
                return [];
            } else {
                return $sth->fetchAll();
            }
        } catch (PDOException $ex) {
            // var_dump($ex);
            // On retourne false si une exception est levée
            return [];
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
            $sql = "SELECT * FROM `patients` 
            INNER JOIN `appointments` ON `patients`.id = `appointments`.idPatient
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

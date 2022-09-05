<?php
require_once(__DIR__ . '/../helpers/database.php');

class Appointment
{

    private int $id;
    private string $dateHour;
    private int $idPatients;

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
            $sql = 'INSERT INTO `appointments` (`dateHour`, `idPatients`) 
                    VALUES (:dateHour, :idPatients)';
            $sth = $this->pdo->prepare($sql);

            $sth->bindValue(':dateHour', $this->getDateHour(), PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->getIdPatients(), PDO::PARAM_INT);
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
    public static function get(int $id): object
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
                        ON `appointments`.`idPatients` = `patients`.`id`
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
}

<?php
class Database
{
    private $host = "localhost";
    private $dbName = "wtc_v4";
    private $username = "root";
    private $password = "root";

    public function __construct()
    {
        $this->checkDB();
        $this->checkTables();
    }

    public function getConnection()
    {
        try {
            // Connect to the database
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    private function checkDB()
    {
        try {
            // Connect to the database
            $pdo = new PDO("mysql:host=$this->host;", $this->username, $this->password);
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database exists
            $result = $pdo->query("SHOW DATABASES LIKE '$this->dbName'");
            if (!$result->fetch()) {
                // Create the database if it does not exist
                $pdo->exec("CREATE DATABASE $this->dbName");
                echo "Base de données créée avec succès";
            }
        } catch (Exception $e) {
            echo "Erreur lors de la vérification de la base de données : " . $e->getMessage();
        }
    }

    private function checkTables()
    {
        try {
            // Connect to the database
            $pdo = $this->getConnection();

            // Check if the tables exist
            $tables = array('client', 'tarif', 'prestation',  "facture");
            foreach ($tables as $table) {
                $result = $pdo->query("SHOW TABLES LIKE '$table'");
                if (!$result->fetch()) {
                    // Create the table if it does not exist
                    switch ($table) {
                        case 'prestation':
                            $pdo->exec("CREATE TABLE prestation (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                date DATE NOT NULL,
                                idClient INT NOT NULL,
                                FOREIGN KEY (idClient) REFERENCES client (id),
                                idTarif INT NOT NULL,
                                FOREIGN KEY (idTarif) REFERENCES tarif (id),
                                duree VARCHAR(50) NOT NULL,
                                description TEXT NOT NULL,
                                facturee BOOLEAN NOT NULL
                            )");
                            break;
                        case 'client':
                            $pdo->exec("CREATE TABLE client (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                nom VARCHAR(50) NOT NULL,
                                prenom VARCHAR(50) NOT NULL,
                                mail VARCHAR(50) NOT NULL,
                                telephone VARCHAR(15) NOT NULL,
                                adresse VARCHAR(100) NOT NULL,
                                description TEXT NOT NULL
                            )");
                            break;
                        case 'tarif':
                            $pdo->exec("CREATE TABLE tarif (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                nom VARCHAR(50) NOT NULL,
                                montantParHeure DOUBLE NOT NULL,
                                description TEXT NOT NULL
                            )");
                            break;
                        case 'facture':
                            $pdo->exec("CREATE TABLE facture (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                date DATE NOT NULL,
                                idClient INT NOT NULL,
                                FOREIGN KEY (idClient) REFERENCES client (id),
                                idsPrestations VARCHAR(50) NOT NULL,
                                payee BOOLEAN NOT NULL,
                                tva DOUBLE NOT NULL
                                )");
                            break;
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erreur lors de la vérification de la base de données : " . $e->getMessage();
        }
    }
}
?>
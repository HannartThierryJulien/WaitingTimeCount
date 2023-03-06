<?php

require_once('../database/database.php');
require_once('prestation.php');

class ActionsDBPrestation
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function addPrestation($prestation)
    {
        $query = "INSERT INTO prestation (date, idClient, idTarif, duree, description, facturee) VALUES (current_date(), :idClient, :idTarif, :duree, :description, :facturee)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':idClient', $prestation->getIdClient());
        $statement->bindValue(':idTarif', $prestation->getIdTarif());
        $statement->bindValue(':duree', $prestation->getDuree());
        $statement->bindValue(':description', $prestation->getDescription());
        $statement->bindValue(':facturee', $prestation->isFacturee());
        $statement->execute();
    }

    public function getPrestationById($id)
    {
        $query = "SELECT * FROM prestation WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $prest = $statement->fetch();
        $prestation = new Prestation();
        $prestation->setAllAttributes($prest['id'], $prest['date'], $prest['idClient'], $prest['idTarif'], $prest['duree'], $prest['description'], $prest['facturee']);
        return $prestation;
    }

    public function getPrestationsByClient($idClient)
    {
        $query = "SELECT * FROM prestation WHERE idClient = :idClient";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':idClient', $idClient);
        $statement->execute();
        
        // Fetch all the results into an array of objects
        $prestations = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $prestation = new Prestation();
            $prestation->setId($row['id']);
            $prestation->setDate($row['date']);
            $prestation->setIdClient($row['idClient']);
            $prestation->setIdTarif($row['idTarif']);
            $prestation->setDuree($row['duree']);
            $prestation->setDescription($row['description']);
            $prestation->setFacturee($row['facturee']);
            $prestations[] = $prestation;
        }

        return $prestations;
    }

    public function getPrestations()
    {
        $query = "SELECT * FROM prestation";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch all the results into an array of objects
        $prestations = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $prestation = new Prestation();
            $prestation->setId($row['id']);
            $prestation->setDate($row['date']);
            $prestation->setIdClient($row['idClient']);
            $prestation->setIdTarif($row['idTarif']);
            $prestation->setDuree($row['duree']);
            $prestation->setDescription($row['description']);
            $prestation->setFacturee($row['facturee']);
            $prestations[] = $prestation;
        }

        return $prestations;
    }

    public function getPrestationsDetaillees()
    {
        $query = "SELECT    prestation.id,
                            prestation.date,
                            client.nom as nomClient,
                            client.prenom as prenomClient,
                            tarif.nom as nomTarif,
                            tarif.montantParHeure as prixTarif,
                            prestation.duree,
                            prestation.description,
                            prestation.facturee
                    FROM prestation
                    INNER JOIN client ON prestation.idClient = client.id
                    INNER JOIN tarif ON prestation.idTarif = tarif.id;";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $prestationsDetaillees = $statement->fetchAll();

        return $prestationsDetaillees;
    }

    public function getPrestationsDetailleesByClient($idClient)
    {
        $query = "SELECT    prestation.id,
                            prestation.date,
                            client.nom as nomClient,
                            client.prenom as prenomClient,
                            tarif.nom as nomTarif,
                            tarif.montantParHeure as prixTarif,
                            prestation.duree,
                            prestation.description,
                            prestation.facturee
                    FROM prestation
                    INNER JOIN client ON prestation.idClient = client.id
                    INNER JOIN tarif ON prestation.idTarif = tarif.id
                    WHERE client.id=" . $idClient . ";";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $prestationsDetaillees = $statement->fetchAll();

        return $prestationsDetaillees;
    }

    public function getPrestationsForFacture($idPrestationsAFacturer)
    {
        $query = "SELECT DISTINCT   prestation.id,
                                    prestation.date,
                                    prestation.idClient,
                                    tarif.nom as nomTarif,
                                    tarif.montantParHeure as prixTarif,
                                    prestation.duree, prestation.description
                            FROM prestation
                            INNER JOIN client ON prestation.idClient = client.id
                            INNER JOIN tarif ON prestation.idTarif = tarif.id
                            WHERE prestation.id IN (" . implode(',', $idPrestationsAFacturer) . ")";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $prestationsDetaillees = $statement->fetchAll();

        return $prestationsDetaillees;
    }

    public function updatePrestation($prestation)
    {
        $query = "UPDATE prestation SET date = :date, idClient = :idClient, idTarif = :idTarif, duree = :duree, description = :description, facturee = :facturee WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':date', $prestation->getDate());
        $statement->bindValue(':idClient', $prestation->getIdClient());
        $statement->bindValue(':idTarif', $prestation->getIdTarif());
        $statement->bindValue(':duree', $prestation->getDuree());
        $statement->bindValue(':description', $prestation->getDescription());
        $statement->bindValue(':facturee', $prestation->isFacturee());
        $statement->bindValue(':id', $prestation->getId());
        $statement->execute();
    }

    public function setFactureeTruePrestation($id)
    {
        $sql = "UPDATE prestation SET facturee=1 WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function deletePrestation($id)
    {
        $sql = "DELETE FROM prestation WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}

?>
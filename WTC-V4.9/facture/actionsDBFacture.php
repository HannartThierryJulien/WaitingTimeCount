<?php

require_once('../database/database.php');
require_once('../prestation/actionsDBPrestation.php');
require_once('facture.php');

class ActionsDBFacture
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function addFacture($facture)
    {

        $query = "INSERT INTO facture (date, idClient, idsPrestations, payee, tva) VALUES (current_date(), :idClient, :idsPrestations, :payee, :tva)";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':idClient', $facture->getIdClient());
        $statement->bindValue(':idsPrestations', $facture->getIdsPrestations());
        $statement->bindValue(':payee', $facture->isPayee());
        $statement->bindValue(':tva', $facture->getTva());

        $statement->execute();

        $tabIdsPrestations = explode(',', $facture->getIdsPrestations());
        $actionsDBPrestation = new ActionsDBPrestation();
        foreach ($tabIdsPrestations as $idPrestation) {
            $actionsDBPrestation->setFactureeTruePrestation($idPrestation);
        }
    }

    public function getFactureById($id)
    {
        $query = "SELECT * FROM facture WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $fa = $statement->fetch();

        $facture = new Facture();
        $facture->setAllAttributes($fa['id'], $fa['date'], $fa['idClient'], $fa['idsPrestations'], $fa['payee'], $fa['tva']);

        return $facture;
    }

    public function getFactures()
    {
        $query = "SELECT * FROM facture";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch all the results into an array of objects
        $factures = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $facture = new Facture();
            $facture->setId($row['id']);
            $facture->setDate($row['date']);
            $facture->setIdClient($row['idClient']);
            $facture->setIdsPrestations($row['idsPrestations']);
            $facture->setPayee($row['payee']);
            $facture->setTva($row['tva']);
            $factures[] = $facture;
        }

        return $factures;
    }

    public function getFacturesDetaillees()
    {
        $query = "SELECT    facture.id,
                            facture.date,
                            concat(client.nom, ' ', client.prenom) as client,
                            facture.idsPrestations,
                            facture.payee,
                            facture.tva
                    FROM facture
                    INNER JOIN client ON facture.idClient = client.id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $facturesDetaillees = $statement->fetchAll();

        return $facturesDetaillees;
    }

    public function updateFacture($facture)
    {

        $query = "UPDATE facture SET date = :date, idClient = :idClient, idsPrestations = :idsPrestations, payee = :payee, tva = :tva WHERE id = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':date', $facture->getDate());
        $statement->bindValue(':idClient', $facture->getIdClient());
        $statement->bindValue(':idsPrestations', $facture->getIdsPrestations());
        $statement->bindValue(':payee', $facture->getPayee());
        $statement->bindValue(':tva', $facture->getTva());
        $statement->bindValue(':id', $facture->getId());

        $statement->execute();
    }

    public function deleteFacture($id)
    {
        $sql = "DELETE FROM facture WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function changerStatusFacture($id)
    {
        $sql = "UPDATE facture SET payee=1 WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}

?>
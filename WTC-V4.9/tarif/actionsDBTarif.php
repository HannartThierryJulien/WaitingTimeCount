<?php

require_once('../database/database.php');
require_once('tarif.php');

class ActionsDBTarif
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function addTarif($tarif)
    {

        $query = "INSERT INTO tarif (nom, montantParHeure, description) VALUES (:nom, :montantParHeure, :description)";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':nom', $tarif->getNom());
        $statement->bindValue(':montantParHeure', $tarif->getMontantParHeure());
        $statement->bindValue(':description', $tarif->getDescription());

        $statement->execute();
    }

    public function getTarifById($id)
    {
        $query = "SELECT * FROM tarif WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $tar = $statement->fetch();

        $tarif = new Tarif();
        $tarif->setAllAttributes($tar['id'], $tar['nom'], $tar['montantParHeure'], $tar['description']);

        return $tarif;
    }

    public function getTarifs()
    {
        $query = "SELECT * FROM tarif";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch all the results into an array of objects
        $tarifs = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $tarif = new Tarif();
            $tarif->setId($row['id']);
            $tarif->setNom($row['nom']);
            $tarif->setMontantParHeure($row['montantParHeure']);
            $tarif->setDescription($row['description']);
            $tarifs[] = $tarif;
        }

        return $tarifs;
    }

    public function updateTarif($tarif)
    {

        $query = "UPDATE tarif SET nom = :nom, montantParHeure = :montantParHeure, description = :description WHERE id = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':nom', $tarif->getNom());
        $statement->bindValue(':montantParHeure', $tarif->getMontantParHeure());
        $statement->bindValue(':description', $tarif->getDescription());
        $statement->bindValue(':id', $tarif->getId());

        $statement->execute();
    }

    public function deleteTarif($id)
    {
        try {
            $sql = "DELETE FROM tarif WHERE id = :id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            ob_start();
            header('Location: ../erreurs/erreurSuppression.php');
            ob_end_flush();
            die();
        }
    }
}

?>
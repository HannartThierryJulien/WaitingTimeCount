<?php

require_once('../database/database.php');
require_once('client.php');

class ActionsDBClient
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function addClient($client)
    {

        $query = "INSERT INTO client (nom, prenom, mail, telephone, adresse, description) VALUES (:nom, :prenom, :mail, :telephone, :adresse, :description)";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':nom', $client->getNom());
        $statement->bindValue(':prenom', $client->getPrenom());
        $statement->bindValue(':mail', $client->getMail());
        $statement->bindValue(':telephone', $client->getTelephone());
        $statement->bindValue(':adresse', $client->getAdresse());
        $statement->bindValue(':description', $client->getDescription());

        $statement->execute();
    }

    public function getClientById($id)
    {
        $query = "SELECT * FROM client WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $cl = $statement->fetch();

        $client = new Client();
        $client->setAllAttributes($cl['id'], $cl['nom'], $cl['prenom'], $cl['mail'], $cl['telephone'], $cl['adresse'], $cl['description']);

        return $client;
    }

    public function getClients()
    {
        $query = "SELECT * FROM client";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        // Fetch all the results into an array of objects
        $clients = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $client = new Client();
            $client->setId($row['id']);
            $client->setNom($row['nom']);
            $client->setPrenom($row['prenom']);
            $client->setMail($row['mail']);
            $client->setTelephone($row['telephone']);
            $client->setAdresse($row['adresse']);
            $client->setDescription($row['description']);
            $clients[] = $client;
        }

        return $clients;
    }

    public function updateClient($client)
    {

        $query = "UPDATE client SET nom = :nom, prenom = :prenom, mail = :mail, telephone = :telephone, adresse = :adresse, description = :description WHERE id = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':nom', $client->getNom());
        $statement->bindValue(':prenom', $client->getPrenom());
        $statement->bindValue(':mail', $client->getMail());
        $statement->bindValue(':telephone', $client->getTelephone());
        $statement->bindValue(':adresse', $client->getAdresse());
        $statement->bindValue(':description', $client->getDescription());
        $statement->bindValue(':id', $client->getId());

        $statement->execute();
    }

    public function deleteClient($id)
    {
        try {
            $sql = "DELETE FROM client WHERE id = :id";
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
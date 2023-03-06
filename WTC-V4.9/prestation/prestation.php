<?php
class Prestation
{
    private $id;
    private $date;
    private $idClient;
    private $idtarif;
    private $duree;
    private $description;
    private $facturee;

    public function __construct()
    {
    }

    public function setAllAttributes($id, $date, $idClient, $idtarif, $duree, $description, $facturee)
    {
        $this->id = $id;
        $this->date = $date;
        $this->idClient = $idClient;
        $this->idtarif = $idtarif;
        $this->duree = $duree;
        $this->description = $description;
        $this->facturee = $facturee;
    }

    public function setAttributesForInsert($idClient, $idtarif, $duree, $description, $facturee)
    {
        $this->idClient = $idClient;
        $this->idtarif = $idtarif;
        $this->duree = $duree;
        $this->description = $description;
        $this->facturee = $facturee;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    public function getIdTarif()
    {
        return $this->idtarif;
    }

    public function setIdTarif($idtarif)
    {
        $this->idtarif = $idtarif;
    }

    public function getDuree()
    {
        return $this->duree;
    }

    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function isFacturee()
    {
        return $this->facturee;
    }

    public function setFacturee($facturee)
    {
        $this->facturee = $facturee;
    }

}
?>
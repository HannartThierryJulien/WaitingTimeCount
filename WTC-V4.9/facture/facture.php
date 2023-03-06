<?php
class Facture
{
    private $id;
    private $date;
    private $idClient;
    private $idsPrestations;
    private $payee;
    private $tva;

    public function __construct()
    {
    }

    public function setAllAttributes($id, $date, $idClient, $idsPrestations, $payee, $tva)
    {
        $this->id = $id;
        $this->date = $date;
        $this->idClient = $idClient;
        $this->idsPrestations = $idsPrestations;
        $this->payee = $payee;
        $this->tva = $tva;
    }

    public function setAttributesForInsert($idClient, $idsPrestations, $payee, $tva)
    {
        $this->idClient = $idClient;
        $this->idsPrestations = $idsPrestations;
        $this->payee = $payee;
        $this->tva = $tva;
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

    public function getIdsPrestations()
    {
        return $this->idsPrestations;
    }

    public function setIdsPrestations($idsPrestations)
    {
        $this->idsPrestations = $idsPrestations;
    }

    public function isPayee()
    {
        return $this->payee;
    }

    public function setPayee($payee)
    {
        $this->payee = $payee;
    }

    public function getTva()
    {
        return $this->tva;
    }

    public function setTva($tva)
    {
        $this->tva = $tva;
    }
}
?>
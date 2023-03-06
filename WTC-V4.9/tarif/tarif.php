<?php
class Tarif
{
    private $id;
    private $nom;
    private $montantparheure;
    private $description;

    public function __construct()
    {
    }

    public function setAllAttributes($id, $nom, $montantparheure, $description)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->montantparheure = $montantparheure;
        $this->description = $description;
    }

    public function setAttributesForInsert($nom, $montantparheure, $description)
    {
        $this->nom = $nom;
        $this->montantparheure = $montantparheure;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getMontantParHeure()
    {
        return $this->montantparheure;
    }

    public function setMontantParHeure($montantparheure)
    {
        $this->montantparheure = $montantparheure;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
?>
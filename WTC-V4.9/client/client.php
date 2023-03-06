<?php
class Client
{
    private $id;
    private $nom;
    private $prenom;
    private $mail;
    private $telephone;
    private $adresse;
    private $description;

    public function __construct()
    {
    }

    public function setAllAttributes($id, $nom, $prenom, $mail, $telephone, $adresse, $description)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->description = $description;
    }

    public function setAttributesForInsert($nom, $prenom, $mail, $telephone, $adresse, $description)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
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

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
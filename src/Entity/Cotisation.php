<?php

namespace App\Entity;

class Cotisation
{
    public $nom;
    public $prenom;
    public $naissance;
    public $ecole;
    public $niveau;
    public $telephone;
    public $optionSalle;
    public $mailEcole;
    public $sportsSouhaites;
    public $remiseSocieteGenerale;
    public $duree;

    public function getCotisation(): string
    {
        return $this->cotisation;
    }

    public function setCotisation(string $cotisation): void
    {
        $this->cotisation = $cotisation;
    }

}
<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CotisationRepository::class)
 */
class Cotisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=511)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=511)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ecole;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optionSalle;

    /**
     * @ORM\Column(type="string", length=511)
     */
    private $mailEcole;

    /**
     * @ORM\Column(type="string", length=1023, nullable=true)
     */
    private $sports;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $remiseSoge;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=1023, nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNaissance(): ?\DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(\DateTimeInterface $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getEcole(): ?string
    {
        return $this->ecole;
    }

    public function setEcole(string $ecole): self
    {
        $this->ecole = $ecole;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getOptionSalle(): ?bool
    {
        return $this->optionSalle;
    }

    public function setOptionSalle(bool $optionSalle): self
    {
        $this->optionSalle = $optionSalle;

        return $this;
    }

    public function getMailEcole(): ?string
    {
        return $this->mailEcole;
    }

    public function setMailEcole(string $mailEcole): self
    {
        $this->mailEcole = $mailEcole;

        return $this;
    }

    public function getSports(): ?string
    {
        return $this->sports;
    }

    public function setSports(?string $sports): self
    {
        $this->sports = $sports;

        return $this;
    }

    public function getRemiseSoge(): ?bool
    {
        return $this->remiseSoge;
    }

    public function setRemiseSoge(?bool $remiseSoge): self
    {
        $this->remiseSoge = $remiseSoge;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }
}

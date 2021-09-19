<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texte;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $respo;

    /**
     * @ORM\ManyToOne(targetEntity=Membre::class, inversedBy="sports")
     */
    private $responsable;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rang;

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

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getRespo(): ?int
    {
        return $this->respo;
    }

    public function setRespo(?int $respo): self
    {
        $this->respo = $respo;

        return $this;
    }

    public function getResponsable(): ?Membre
    {
        return $this->responsable;
    }

    public function setResponsable(?Membre $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(?int $rang): self
    {
        $this->rang = $rang;

        return $this;
    }
}

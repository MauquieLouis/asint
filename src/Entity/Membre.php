<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pole;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $lienfb;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $lienInsta;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $lienlinkedin;

    /**
     * @ORM\Column(type="integer")
     */
    private $rang;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autre;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $photo;

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

    public function getPole(): ?string
    {
        return $this->pole;
    }

    public function setPole(string $pole): self
    {
        $this->pole = $pole;

        return $this;
    }

    public function getLienfb(): ?string
    {
        return $this->lienfb;
    }

    public function setLienfb(?string $lienfb): self
    {
        $this->lienfb = $lienfb;

        return $this;
    }

    public function getLienInsta(): ?string
    {
        return $this->lienInsta;
    }

    public function setLienInsta(?string $lienInsta): self
    {
        $this->lienInsta = $lienInsta;

        return $this;
    }

    public function getLienlinkedin(): ?string
    {
        return $this->lienlinkedin;
    }

    public function setLienlinkedin(?string $lienlinkedin): self
    {
        $this->lienlinkedin = $lienlinkedin;

        return $this;
    }

    public function getRang(): ?int
    {
        return $this->rang;
    }

    public function setRang(int $rang): self
    {
        $this->rang = $rang;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->autre;
    }

    public function setAutre(?string $autre): self
    {
        $this->autre = $autre;

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
}

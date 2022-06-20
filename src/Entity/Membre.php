<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="responsable")
     */
    private $sports;

    /**
     * @ORM\ManyToMany(targetEntity=Club::class, mappedBy="pres")
     */
    private $clubs;

    /**
     * @ORM\ManyToOne(targetEntity=Year::class, inversedBy="membres")
     */
    private $year;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
        $this->clubs = new ArrayCollection();
    }

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

    /**
     * @return Collection|Sport[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
            $sport->setResponsable($this);
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        if ($this->sports->removeElement($sport)) {
            // set the owning side to null (unless already changed)
            if ($sport->getResponsable() === $this) {
                $sport->setResponsable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
            $club->addPre($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->removeElement($club)) {
            $club->removePre($this);
        }

        return $this;
    }
    
    public function __toString(){
        return $this->getId();
    }

    public function getYear(): ?Year
    {
        return $this->year;
    }

    public function setYear(?Year $year): self
    {
        $this->year = $year;

        return $this;
    }
}

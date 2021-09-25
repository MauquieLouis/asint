<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
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
     * @ORM\ManyToMany(targetEntity=Membre::class, inversedBy="clubs")
     */
    private $pres;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texte;

    public function __construct()
    {
        $this->pres = new ArrayCollection();
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

    /**
     * @return Collection|Membre[]
     */
    public function getPres(): Collection
    {
        return $this->pres;
    }

    public function addPre(Membre $pre): self
    {
        if (!$this->pres->contains($pre)) {
            $this->pres[] = $pre;
        }

        return $this;
    }

    public function removePre(Membre $pre): self
    {
        $this->pres->removeElement($pre);

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

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }
    public function __toString(){
        return $this->getId();
    }
}

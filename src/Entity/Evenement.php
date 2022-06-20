<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fini;

    /**
     * @ORM\OneToMany(targetEntity=PhotoEvent::class, mappedBy="evenement")
     */
    private $photoEvents;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creation;

    /**
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $link;

    public function __construct()
    {
        $this->photoEvents = new ArrayCollection();
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

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFini(): ?bool
    {
        return $this->fini;
    }

    public function setFini(?bool $fini): self
    {
        $this->fini = $fini;

        return $this;
    }

    /**
     * @return Collection|PhotoEvent[]
     */
    public function getPhotoEvents(): Collection
    {
        return $this->photoEvents;
    }

    public function addPhotoEvent(PhotoEvent $photoEvent): self
    {
        if (!$this->photoEvents->contains($photoEvent)) {
            $this->photoEvents[] = $photoEvent;
            $photoEvent->setEvenement($this);
        }

        return $this;
    }

    public function removePhotoEvent(PhotoEvent $photoEvent): self
    {
        if ($this->photoEvents->removeElement($photoEvent)) {
            // set the owning side to null (unless already changed)
            if ($photoEvent->getEvenement() === $this) {
                $photoEvent->setEvenement(null);
            }
        }

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(?\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}

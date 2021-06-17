<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Recruteur::class, inversedBy="categories")
     */
    private $recruteur;

    /**
     * @ORM\OneToMany(targetEntity=OffreDemploi::class, mappedBy="categorie")
     */
    private $offreDemplois;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $daterdz;

    public function __construct()
    {
        $this->offreDemplois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRecruteur(): ?Recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?Recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }

    /**
     * @return Collection|OffreDemploi[]
     */
    public function getOffreDemplois(): Collection
    {
        return $this->offreDemplois;
    }

    public function addOffreDemploi(OffreDemploi $offreDemploi): self
    {
        if (!$this->offreDemplois->contains($offreDemploi)) {
            $this->offreDemplois[] = $offreDemploi;
            $offreDemploi->setCategorie($this);
        }

        return $this;
    }

    public function removeOffreDemploi(OffreDemploi $offreDemploi): self
    {
        if ($this->offreDemplois->removeElement($offreDemploi)) {
            // set the owning side to null (unless already changed)
            if ($offreDemploi->getCategorie() === $this) {
                $offreDemploi->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getDaterdz(): ?\DateTimeInterface
    {
        return $this->daterdz;
    }

    public function setDaterdz(?\DateTimeInterface $daterdz): self
    {
        $this->daterdz = $daterdz;

        return $this;
    }
}

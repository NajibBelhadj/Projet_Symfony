<?php

namespace App\Entity;

use App\Repository\RecruteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecruteurRepository::class)
 */
class Recruteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="recruteur", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $responsabilite;

    /**
     * @ORM\OneToMany(targetEntity=OffreDemploi::class, mappedBy="recruteur", cascade={"persist", "remove"})
     */
    private $offreDemplois;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="recruteur", cascade={"persist", "remove"})
     */
    private $categories;

    public function __construct()
    {
        $this->offreDemplois = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(?int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getResponsabilite(): ?string
    {
        return $this->responsabilite;
    }

    public function setResponsabilite(?string $responsabilite): self
    {
        $this->responsabilite = $responsabilite;

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
            $offreDemploi->setRecruteur($this);
        }

        return $this;
    }

    public function removeOffreDemploi(OffreDemploi $offreDemploi): self
    {
        if ($this->offreDemplois->removeElement($offreDemploi)) {
            // set the owning side to null (unless already changed)
            if ($offreDemploi->getRecruteur() === $this) {
                $offreDemploi->setRecruteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setRecruteur($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getRecruteur() === $this) {
                $category->setRecruteur(null);
            }
        }

        return $this;
    }
}

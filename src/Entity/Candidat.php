<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @ORM\Entity(repositoryClass=CandidatRepository::class)
 */
class Candidat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $qui_je_suis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=CenterInreret::class, mappedBy="candidat", cascade={"persist", "remove"})
     */
    private $centerInrerets;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="candidat", cascade={"persist", "remove"})
     */
    private $experiences;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="candidat", cascade={"persist", "remove"})
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Professionelle::class, mappedBy="candidat", cascade={"persist", "remove"})
     */
    private $professionelles;

    /**
     * @ORM\OneToMany(targetEntity=Personelle::class, mappedBy="candidat", cascade={"persist", "remove"})
     */
    private $personelles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_postulation_autorisee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedin;

    public function __construct()
    {
        $this->centerInrerets = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->professionelles = new ArrayCollection();
        $this->personelles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuiJeSuis(): ?string
    {
        return $this->qui_je_suis;
    }

    public function setQuiJeSuis(?string $qui_je_suis): self
    {
        $this->qui_je_suis = $qui_je_suis;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCandidat($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCandidat() === $this) {
                $formation->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Personelle[]
     */
    public function getPersonelles(): Collection
    {
        return $this->personelles;
    }

    public function addPersonelle(Personelle $personelle): self
    {
        if (!$this->personelles->contains($personelle)) {
            $this->personelles[] = $personelle;
            $personelle->setCandidat($this);
        }

        return $this;
    }

    public function removePersonelle(Personelle $personelle): self
    {
        if ($this->personelles->removeElement($personelle)) {
            // set the owning side to null (unless already changed)
            if ($personelle->getCandidat() === $this) {
                $personelle->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Professionelle[]
     */
    public function getProfessionelles(): Collection
    {
        return $this->professionelles;
    }

    public function addProfessionelle(Professionelle $professionelle): self
    {
        if (!$this->professionelles->contains($professionelle)) {
            $this->professionelles[] = $professionelle;
            $professionelle->setCandidat($this);
        }

        return $this;
    }

    public function removeProfessionelle(Professionelle $professionelle): self
    {
        if ($this->professionelles->removeElement($professionelle)) {
            // set the owning side to null (unless already changed)
            if ($professionelle->getCandidat() === $this) {
                $professionelle->setCandidat(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|CenterInreret[]
     */
    public function getCenterInrerets(): Collection
    {
        return $this->centerInrerets;
    }

    public function addCenterInreret(CenterInreret $centerInreret): self
    {
        if (!$this->centerInrerets->contains($centerInreret)) {
            $this->centerInrerets[] = $centerInreret;
            $centerInreret->setCandidat($this);
        }

        return $this;
    }

    public function removeCenterInreret(CenterInreret $centerInreret): self
    {
        if ($this->centerInrerets->removeElement($centerInreret)) {
            // set the owning side to null (unless already changed)
            if ($centerInreret->getCandidat() === $this) {
                $centerInreret->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setCandidat($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->$experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getCandidat() === $this) {
                $experience->setCandidat(null);
            }
        }

        return $this;
    }

    public function getNbPostulationAutorisee(): ?int
    {
        return $this->nb_postulation_autorisee;
    }

    public function setNbPostulationAutorisee(?int $nb_postulation_autorisee): self
    {
        $this->nb_postulation_autorisee = $nb_postulation_autorisee;

        return $this;
    }


    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }
}

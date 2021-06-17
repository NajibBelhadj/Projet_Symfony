<?php

namespace App\Entity;

use App\Repository\CandidaturesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidaturesRepository::class)
 */
class Candidatures
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity=OffreDemploi::class, inversedBy="candidatures")
     */
    private $offre;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validation;



    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $daterdz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(?User $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getOffre(): ?OffreDemploi
    {
        return $this->offre;
    }

    public function setOffre(?OffreDemploi $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(?bool $validation): self
    {
        $this->validation = $validation;

        return $this;
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

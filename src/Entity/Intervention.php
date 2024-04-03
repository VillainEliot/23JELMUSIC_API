<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api')]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups('api')]
    #[Assert\Expression(
        "this.getDateFin() === null or this.getDateDebut() < this.getDateFin()",
        message: "La date de début ne peut pas être supérieure à la date de fin"
    )]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups('api')]
    #[Assert\Expression(
        "this.getDateDebut() === null or this.getDateFin() === null or this.getDateDebut() < this.getDateFin()",
        message: "La date de fin ne peut pas être antérieure à la date de début"
    )]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('api')]
    private ?string $descriptif = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups('api')]
    private ?Instrument $instrument = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups('api')]
    private ?Professionnel $professionnel = null;

    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: InterPret::class)]
    #[Groups('api')]
    private Collection $interPrets;

    public function __construct()
    {
        $this->interPrets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }
  
    public function setDescriptif(?string $descriptif): static
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }
  
    public function getProfessionnel(): ?Professionnel
    {
        return $this->professionnel;
    }

    public function setProfessionnel(?Professionnel $professionnel): static
    {
        $this->professionnel = $professionnel;

        return $this;
    }

    /**
     * @return Collection<int, InterPret>
     */
    public function getInterPrets(): Collection
    {
        return $this->interPrets;
    }

    public function addInterPret(InterPret $interPret): static
    {
        if (!$this->interPrets->contains($interPret)) {
            $this->interPrets->add($interPret);
            $interPret->setIntervention($this);
        }

        return $this;
    }

    public function removeInterPret(InterPret $interPret): static
    {
        if ($this->interPrets->removeElement($interPret)) {
            // set the owning side to null (unless already changed)
            if ($interPret->getIntervention() === $this) {
                $interPret->setIntervention(null);
            }
        }

        return $this;
    }
}

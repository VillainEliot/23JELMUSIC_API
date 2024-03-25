<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex(pattern:"/^\d+$/", message:"Veuillez saisir uniquement des chiffres.")]
    #[Assert\Range(
        notInRangeMessage: "L'age ne doit pas être plus être plus petit que 3 ans et plus grand que 99 ans",
        min: 3,
        max: 99)]
    #[Assert\Expression('this.getAgeMini() < this.getAgeMaxi()',
        message:"L'age minimum ne peux pas être supérieur à l'age maximum.")]
    private ?string $AgeMini = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Expression('this.getHeureDebut() < this.getHeureFin()',
        message:"L'heure de début ne peut pas être supérieure à l'heure de fin.")]
    #[Assert\LessThan('07:00',
        message: 'L\'heure de début doit être supérieur à 7h'),]
    private ?\DateTimeInterface $HeureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Expression('this.getHeureDebut() < this.getHeureFin()',
        message:"L'heure de fin ne peut pas être antérieure à l'heure de début.")]
    #[Assert\LessThan('07:00',
        message: 'L\'heure de fin doit être supérieur à 7h'),]
    private ?\DateTimeInterface $HeureFin = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Le nombre de places doit être supérieur à zéro.")]
    #[Assert\Range(
        notInRangeMessage: "Le nombre de place ne peut pas être supérieur à 25 et inférieur à 1",
        min: 1,
        max: 25)]
    private ?int $NbPlaces = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex(pattern:"/^\d+$/", message:"Veuillez saisir uniquement des chiffres.")]
    #[Assert\Range(
        notInRangeMessage: "L'age ne doit pas être plus être plus petit que 3 ans et plus grand que 99 ans",
        min: 3,
        max: 99)]
    #[Assert\Expression('this.getAgeMini() < this.getAgeMaxi()',
        message:"L'age minimum ne peux pas être supérieur à l'age maximum.")]
    private ?string $AgeMaxi = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeCours $typeCours = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Jours $jours = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Professeur $professeur = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeInstrument $typeInstruments = null;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgeMini(): ?string
    {
        return $this->AgeMini;
    }

    public function setAgeMini(string $AgeMini): static
    {
        $this->AgeMini = $AgeMini;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->HeureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $HeureDebut): static
    {
        $this->HeureDebut = $HeureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->HeureFin;
    }

    public function setHeureFin(\DateTimeInterface $HeureFin): static
    {
        $this->HeureFin = $HeureFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->NbPlaces;
    }

    public function setNbPlaces(int $NbPlaces): static
    {
        $this->NbPlaces = $NbPlaces;

        return $this;
    }

    public function getAgeMaxi(): ?string
    {
        return $this->AgeMaxi;
    }

    public function setAgeMaxi(string $AgeMaxi): static
    {
        $this->AgeMaxi = $AgeMaxi;

        return $this;
    }

    public function getTypeCours(): ?TypeCours
    {
        return $this->typeCours;
    }

    public function setTypeCours(?TypeCours $typeCours): static
    {
        $this->typeCours = $typeCours;

        return $this;
    }

    public function getJours(): ?Jours
    {
        return $this->jours;
    }

    public function setJours(?Jours $jours): static
    {
        $this->jours = $jours;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscriptions(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setCours($this);
        }

        return $this;
    }

    public function removeInscriptions(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getCours() === $this) {
                $inscription->setCours(null);
            }
        }

        return $this;
    }

    public function getTypeInstruments(): ?TypeInstrument
    {
        return $this->typeInstruments;
    }

    public function setTypeInstruments(?TypeInstrument $typeInstruments): static
    {
        $this->typeInstruments = $typeInstruments;

        return $this;
    }
}

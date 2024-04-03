<?php

namespace App\Entity;

use App\Repository\TypeInstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeInstrumentRepository::class)]
class TypeInstrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups('api')]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'typeInstruments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('api')]
    private ?ClasseInstrument $classe = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Instrument::class)]
    #[Groups('api')]
    private Collection $instruments;

    #[ORM\OneToMany(mappedBy: 'typeInstruments', targetEntity: Cours::class)]
    #[Groups('api')]
    private Collection $cours;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getClasse(): ?ClasseInstrument
    {
        return $this->classe;
    }

    public function setClasse(?ClasseInstrument $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, Instrument>
     */
    public function getInstruments(): Collection
    {
        return $this->instruments;
    }

    public function addInstrument(Instrument $instrument): static
    {
        if (!$this->instruments->contains($instrument)) {
            $this->instruments->add($instrument);
            $instrument->setType($this);
        }

        return $this;
    }

    public function removeInstrument(Instrument $instrument): static
    {
        if ($this->instruments->removeElement($instrument)) {
            // set the owning side to null (unless already changed)
            if ($instrument->getType() === $this) {
                $instrument->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setTypeInstruments($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTypeInstruments() === $this) {
                $cour->setTypeInstruments(null);
            }
        }

        return $this;
    }
}

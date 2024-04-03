<?php

namespace App\Entity;

use App\Repository\ProfessionnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfessionnelRepository::class)]
class Professionnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api')]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups('api')]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?int $numRue = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups('api')]
    private ?string $rue = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?int $copos = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('api')]
    private ?string $ville = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('api')]
    #[Assert\Email(message:"Veuillez saisir un mail valide")]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'professionnel', targetEntity: Intervention::class)]
    #[Groups('api')]
    private Collection $interventions;

    #[ORM\ManyToMany(targetEntity: Metier::class, inversedBy: 'professionnels')]
    #[Groups('api')]
    private Collection $metier;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
        $this->metier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumRue(): ?int
    {
        return $this->numRue;
    }

    public function setNumRue(?int $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCopos(): ?int
    {
        return $this->copos;
    }

    public function setCopos(?int $copos): static
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setProfessionnel($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getProfessionnel() === $this) {
                $intervention->setProfessionnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Metier>
     */
    public function getMetier(): Collection
    {
        return $this->metier;
    }

    public function addMetier(Metier $metier): static
    {
        if (!$this->metier->contains($metier)) {
            $this->metier->add($metier);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): static
    {
        $this->metier->removeElement($metier);

        return $this;
    }
}

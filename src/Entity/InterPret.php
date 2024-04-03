<?php

namespace App\Entity;

use App\Repository\InterPretRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InterPretRepository::class)]
class InterPret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api')]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups('api')]
    private ?int $quotite = null;

    #[ORM\ManyToOne(inversedBy: 'interPrets')]
    #[Groups('api')]
    private ?Intervention $intervention = null;

    #[ORM\ManyToOne(inversedBy: 'interPrets')]
    #[Groups('api')]
    private ?ContratPret $contratPret = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuotite(): ?int
    {
        return $this->quotite;
    }

    public function setQuotite(?int $quotite): static
    {
        $this->quotite = $quotite;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): static
    {
        $this->intervention = $intervention;

        return $this;
    }

    public function getContratPret(): ?ContratPret
    {
        return $this->contratPret;
    }

    public function setContratPret(?ContratPret $contratPret): static
    {
        $this->contratPret = $contratPret;

        return $this;
    }
}

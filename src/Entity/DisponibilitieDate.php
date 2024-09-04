<?php

namespace App\Entity;

use App\Repository\DisponibilitieDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibilitieDateRepository::class)]
class DisponibilitieDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $startedAt = null;

    #[ORM\Column]
    private ?\DateTime $endedAt = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilitieDates')]
    private ?Advertise $Advertise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTime $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTime
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTime $endedAt): static
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getAdvertise(): ?Advertise
    {
        return $this->Advertise;
    }

    public function setAdvertise(?Advertise $Advertise): static
    {
        $this->Advertise = $Advertise;

        return $this;
    }
}

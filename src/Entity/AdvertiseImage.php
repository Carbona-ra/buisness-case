<?php

namespace App\Entity;

use App\Repository\AdvertiseImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AdvertiseImageRepository::class)]
class AdvertiseImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'advertiseImages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['advertise:read'])]
    private ?Advertise $Avertise = null;

    #[ORM\Column(length: 255)]
    #[Groups(['advertise:read'])]
    private ?string $imageSlug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvertise(): ?Advertise
    {
        return $this->Avertise;
    }

    public function setAvertise(?Advertise $Avertise): static
    {
        $this->Avertise = $Avertise;

        return $this;
    }

    public function getImageSlug(): ?string
    {
        return $this->imageSlug;
    }

    public function setImageSlug(string $imageSlug): static
    {
        $this->imageSlug = $imageSlug;

        return $this;
    }
}

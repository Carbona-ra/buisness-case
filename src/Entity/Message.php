<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\Get;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource(normalizationContext: ['groups' => 'message:item'], paginationEnabled: false)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['message:read'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['message:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[Groups(['message:read'])]
    private ?user $sender = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[Groups(['message:read'])]
    private ?user $reciver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSender(): ?user
    {
        return $this->sender;
    }

    public function setSender(?user $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getTarget(): ?user
    {
        return $this->reciver;
    }

    public function setTarget(?user $reciver): static
    {
        $this->reciver = $reciver;

        return $this;
    }
}

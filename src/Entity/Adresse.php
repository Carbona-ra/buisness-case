<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'advertise:read'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'advertise:read'])]
    private ?string $streetName = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['user:read', 'advertise:read'])]
    private ?int $adresseNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'advertise:read'])]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups(['user:read', 'advertise:read'])]
    private ?int $postalCode = null;

    /**
     * @var Collection<int, Advertise>
     */
    #[ORM\OneToMany(targetEntity: Advertise::class, mappedBy: 'adresse')]
    private Collection $advertises;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'adresse')]
    private Collection $users;

    public function __construct()
    {
        $this->advertises = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getAdresseNumber(): ?int
    {
        return $this->adresseNumber;
    }

    public function setAdresseNumber(int $adresseNumber): static
    {
        $this->adresseNumber = $adresseNumber;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, Advertise>
     */
    public function getAdvertises(): Collection
    {
        return $this->advertises;
    }

    public function addAdvertise(Advertise $advertise): static
    {
        if (!$this->advertises->contains($advertise)) {
            $this->advertises->add($advertise);
            $advertise->setAdresse($this);
        }

        return $this;
    }

    public function removeAdvertise(Advertise $advertise): static
    {
        if ($this->advertises->removeElement($advertise)) {
            // set the owning side to null (unless already changed)
            if ($advertise->getAdresse() === $this) {
                $advertise->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAdresse($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAdresse() === $this) {
                $user->setAdresse(null);
            }
        }

        return $this;
    }

}

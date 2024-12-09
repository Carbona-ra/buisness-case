<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdvertiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: AdvertiseRepository::class)]
#[ApiFilter(SearchFilter::class, properties: [
    'price' => 'exact',
    'place' => 'exact',
    'totalPlaceNumber' => 'exact',
])]
#[ApiResource(normalizationContext: ['groups' => ['advertise:read']], paginationEnabled: false)]
class Advertise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['advertise:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['advertise:read', 'user:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['advertise:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['advertise:read'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'advertises')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['advertise:read'])]
    private ?Adresse $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['advertise:read'])]
    private ?string $presentationPicture = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['advertise:read'])]
    private ?string $gallery = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['advertise:read'])]
    private ?int $totalPlaceNumber = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['advertise:read'])]
    private ?int $ActualNumberPlace = null;

    #[ORM\ManyToOne(inversedBy: 'Advertise')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['advertise:read'])]
    private ?User $owner = null;

    /**
     * @var Collection<int, Reaction>
     */
    #[Groups(['advertise:read'])]
    #[ORM\OneToMany(targetEntity: Reaction::class, mappedBy: 'Advertise')]
    private Collection $reactions;

    /**
     * @var Collection<int, AdvertiseImage>
     */
    #[Groups(['advertise:read'])]
    #[ORM\OneToMany(targetEntity: AdvertiseImage::class, mappedBy: 'Avertise')]
    private Collection $advertiseImages;

    /**
     * @var Collection<int, DisponibilitieDate>
     */
    #[Groups(['advertise:read'])]
    #[ORM\OneToMany(targetEntity: DisponibilitieDate::class, mappedBy: 'Advertise')]
    private Collection $disponibilitieDates;

    /**
     * @var Collection<int, Reservation>
     */
    #[Groups(['advertise:read'])]
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Advertise')]
    private Collection $reservations;

    /**
     * @var Collection<int, Service>
     */
    #[Groups(['advertise:read'])]
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'Advertise')]
    private Collection $services;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->advertiseImages = new ArrayCollection();
        $this->disponibilitieDates = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPresentationPicture(): ?string
    {
        return $this->presentationPicture;
    }

    public function setPresentationPicture(string $presentationPicture): static
    {
        $this->presentationPicture = $presentationPicture;

        return $this;
    }

    public function getGallery(): ?string
    {
        return $this->gallery;
    }

    public function setGallery(?string $gallery): static
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getTotalPlaceNumber(): ?int
    {
        return $this->totalPlaceNumber;
    }

    public function setTotalPlaceNumber(int $totalPlaceNumber): static
    {
        $this->totalPlaceNumber = $totalPlaceNumber;

        return $this;
    }

    public function getActualNumberPlace(): ?int
    {
        return $this->ActualNumberPlace;
    }

    public function setActualNumberPlace(int $ActualNumberPlace): static
    {
        $this->ActualNumberPlace = $ActualNumberPlace;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $user): static
    {
        $this->owner = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reaction>
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): static
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions->add($reaction);
            $reaction->setAdvertise($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): static
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getAdvertise() === $this) {
                $reaction->setAdvertise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdvertiseImage>
     */
    public function getAdvertiseImages(): Collection
    {
        return $this->advertiseImages;
    }

    public function addAdvertiseImage(AdvertiseImage $advertiseImage): static
    {
        if (!$this->advertiseImages->contains($advertiseImage)) {
            $this->advertiseImages->add($advertiseImage);
            $advertiseImage->setAvertise($this);
        }

        return $this;
    }

    public function removeAdvertiseImage(AdvertiseImage $advertiseImage): static
    {
        if ($this->advertiseImages->removeElement($advertiseImage)) {
            // set the owning side to null (unless already changed)
            if ($advertiseImage->getAvertise() === $this) {
                $advertiseImage->setAvertise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DisponibilitieDate>
     */
    public function getDisponibilitieDates(): Collection
    {
        return $this->disponibilitieDates;
    }

    public function addDisponibilitieDate(DisponibilitieDate $disponibilitieDate): static
    {
        if (!$this->disponibilitieDates->contains($disponibilitieDate)) {
            $this->disponibilitieDates->add($disponibilitieDate);
            $disponibilitieDate->setAdvertise($this);
        }

        return $this;
    }

    public function removeDisponibilitieDate(DisponibilitieDate $disponibilitieDate): static
    {
        if ($this->disponibilitieDates->removeElement($disponibilitieDate)) {
            // set the owning side to null (unless already changed)
            if ($disponibilitieDate->getAdvertise() === $this) {
                $disponibilitieDate->setAdvertise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setAdvertise($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getAdvertise() === $this) {
                $reservation->setAdvertise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setAdvertise($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getAdvertise() === $this) {
                $service->setAdvertise(null);
            }
        }

        return $this;
    }
}

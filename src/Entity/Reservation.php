<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;

// TODO: Add missing properties tripId, ownerId and there filters

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:create', 'reservation:update']],
    security: "is_granted('ROLE_USER')",
)]
class Reservation
{
    #[Groups(['reservation:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['reservation:read', 'reservation:create', 'reservation:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[ApiFilter(DateFilter::class)]
    private ?\DateTimeInterface $date = null;

    #[Groups(['reservation:read', 'reservation:create', 'reservation:update'])]
    #[ORM\Column]
    #[ApiFilter(RangeFilter::class)]
    private ?int $seatNumber = null;

    #[Groups(['reservation:read', 'reservation:create', 'reservation:update'])]
    #[ORM\Column]
    #[ApiFilter(RangeFilter::class)]
    private ?float $totalPrice = null;

    #[Groups(['reservation:read'])]
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?FishingTrip $fishingTrip = null;

    #[Groups(['reservation:read', 'reservation:create'])]
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): static
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getFishingTrip(): ?FishingTrip
    {
        return $this->fishingTrip;
    }

    public function setFishingTrip(?FishingTrip $fishingTrip): static
    {
        $this->fishingTrip = $fishingTrip;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}

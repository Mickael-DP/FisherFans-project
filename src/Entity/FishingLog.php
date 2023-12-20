<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FishingLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FishingLogRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['log:read']],
    denormalizationContext: ['groups' => ['log:create', 'log:update']],
    security: "is_granted('ROLE_USER')",
)]
class FishingLog
{
    #[Groups(['log:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $fishName = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $photoUrl = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column]
    private ?float $sizeCm = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column]
    private ?float $weightKg = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $fishingLocation = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[ApiFilter(RangeFilter::class)]
    private ?\DateTimeInterface $fishingDate = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $fishReleased = null;

    #[Groups(['log:read', 'log:create'])]
    #[ORM\ManyToOne(inversedBy: 'fishingLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFishName(): ?string
    {
        return $this->fishName;
    }

    public function setFishName(string $fishName): static
    {
        $this->fishName = $fishName;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl(string $photoUrl): static
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSizeCm(): ?float
    {
        return $this->sizeCm;
    }

    public function setSizeCm(float $sizeCm): static
    {
        $this->sizeCm = $sizeCm;

        return $this;
    }

    public function getWeightKg(): ?float
    {
        return $this->weightKg;
    }

    public function setWeightKg(float $weightKg): static
    {
        $this->weightKg = $weightKg;

        return $this;
    }

    public function getFishingLocation(): ?string
    {
        return $this->fishingLocation;
    }

    public function setFishingLocation(string $fishingLocation): static
    {
        $this->fishingLocation = $fishingLocation;

        return $this;
    }

    public function getFishingDate(): ?\DateTimeInterface
    {
        return $this->fishingDate;
    }

    public function setFishingDate(\DateTimeInterface $fishingDate): static
    {
        $this->fishingDate = $fishingDate;

        return $this;
    }

    public function getFishReleased(): ?string
    {
        return $this->fishReleased;
    }

    public function setFishReleased(string $fishReleased): static
    {
        $this->fishReleased = $fishReleased;

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

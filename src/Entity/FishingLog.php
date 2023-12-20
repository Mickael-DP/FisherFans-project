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
    private ?string $fish_name = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $photo_url = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column]
    private ?float $size_cm = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column]
    private ?float $weight_kg = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $fishing_location = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[ApiFilter(RangeFilter::class)]
    private ?\DateTimeInterface $fishing_date = null;

    #[Groups(['log:read', 'log:create', 'log:update'])]
    #[ORM\Column(length: 255)]
    private ?string $fish_released = null;

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
        return $this->fish_name;
    }

    public function setFishName(string $fish_name): static
    {
        $this->fish_name = $fish_name;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function setPhotoUrl(string $photo_url): static
    {
        $this->photo_url = $photo_url;

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
        return $this->size_cm;
    }

    public function setSizeCm(float $size_cm): static
    {
        $this->size_cm = $size_cm;

        return $this;
    }

    public function getWeightKg(): ?float
    {
        return $this->weight_kg;
    }

    public function setWeightKg(float $weight_kg): static
    {
        $this->weight_kg = $weight_kg;

        return $this;
    }

    public function getFishingLocation(): ?string
    {
        return $this->fishing_location;
    }

    public function setFishingLocation(string $fishing_location): static
    {
        $this->fishing_location = $fishing_location;

        return $this;
    }

    public function getFishingDate(): ?\DateTimeInterface
    {
        return $this->fishing_date;
    }

    public function setFishingDate(\DateTimeInterface $fishing_date): static
    {
        $this->fishing_date = $fishing_date;

        return $this;
    }

    public function getFishReleased(): ?string
    {
        return $this->fish_released;
    }

    public function setFishReleased(string $fish_released): static
    {
        $this->fish_released = $fish_released;

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

<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
        new Get(uriTemplate: '/boats/in-area', openapiContext: [
            'summary' => 'Retrieve a list of boats within a specified geographic area',
            'parameters' => [
                [
                    'name' => 'latitude',
                    'in' => 'query',
                    'required' => true,
                    'schema' => [
                        'type' => 'number',
                        'format' => 'float',
                    ],
                ],
                [
                    'name' => 'longitude',
                    'in' => 'query',
                    'required' => true,
                    'schema' => [
                        'type' => 'number',
                        'format' => 'float',
                    ],
                ],
                [
                    'name' => 'radius',
                    'in' => 'query',
                    'required' => true,
                    'schema' => [
                        'type' => 'number',
                        'format' => 'float',
                    ],
                ],
            ],
            'responses' => [
                '200' => [
                    'description' => 'Boats in area',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'array',    
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ],
    normalizationContext: ['groups' => ['boat:read']],
    denormalizationContext: ['groups' => ['boat:create', 'boat:update']],
    security: "is_granted('ROLE_USER')"
)]
class Boat
{
    #[Groups(['boat:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $name = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?int $manufacturingYear = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    private ?string $photoURL = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $requiredLicenseType = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $boatType = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(type: Types::ARRAY)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private array $equipment = [];

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column]
    private ?float $depositAmount = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?int $maxCapacity = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $propulsionType = null;

    #[Groups(['boat:read', 'boat:create', 'boat:update'])]
    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $size = null;

    #[Groups(['boat:read'])]
    #[ORM\ManyToOne(inversedBy: 'boats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getManufacturingYear(): ?int
    {
        return $this->manufacturingYear;
    }

    public function setManufacturingYear(int $manufacturingYear): static
    {
        $this->manufacturingYear = $manufacturingYear;

        return $this;
    }

    public function getPhotoURL(): ?string
    {
        return $this->photoURL;
    }

    public function setPhotoURL(string $photoURL): static
    {
        $this->photoURL = $photoURL;

        return $this;
    }

    public function getRequiredLicenseType(): ?string
    {
        return $this->requiredLicenseType;
    }

    public function setRequiredLicenseType(string $requiredLicenseType): static
    {
        $this->requiredLicenseType = $requiredLicenseType;

        return $this;
    }

    public function getBoatType(): ?string
    {
        return $this->boatType;
    }

    public function setBoatType(string $boatType): static
    {
        $this->boatType = $boatType;

        return $this;
    }

    public function getEquipment(): array
    {
        return $this->equipment;
    }

    public function setEquipment(array $equipment): static
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getDepositAmount(): ?float
    {
        return $this->depositAmount;
    }

    public function setDepositAmount(float $depositAmount): static
    {
        $this->depositAmount = $depositAmount;

        return $this;
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): static
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function getPropulsionType(): ?string
    {
        return $this->propulsionType;
    }

    public function setPropulsionType(string $propulsionType): static
    {
        $this->propulsionType = $propulsionType;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

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

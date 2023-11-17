<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BoatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
#[ApiResource]
class Boat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column]
    private ?int $manufacturingYear = null;

    #[ORM\Column(length: 255)]
    private ?string $photoURL = null;

    #[ORM\Column(length: 255)]
    private ?string $requiredLicenseType = null;

    #[ORM\Column(length: 255)]
    private ?string $boatType = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $equipment = [];

    #[ORM\Column]
    private ?float $depositAmount = null;

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
}

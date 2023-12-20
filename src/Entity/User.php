<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(operations: [
    new GetCollection(security: "is_granted('ROLE_USER')"),
    new Post(validationContext: ['groups' => ['Default', 'user:create']], processor: UserPasswordHasher::class),
    new Get(security: "is_granted('ROLE_USER')"),
    new Put(processor: UserPasswordHasher::class, security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')"),
],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 50)]
    private ?string $phone = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 20)]
    private ?string $postalCode = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $languagesSpoken = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatarUrl = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $boatingLicenseNumber = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $insuranceNumber = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activityType = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siretNumber = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255)]
    private ?string $commerceRegisterNumber = null;


    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user:create', 'user:update'])]
    private ?string $plainPassword = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: FishingTrip::class)]
    private Collection $fishingTrips;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Boat::class)]
    private Collection $boats;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: FishingLog::class)]
    private Collection $fishingLogs;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->fishingTrips = new ArrayCollection();
        $this->boats = new ArrayCollection();
        $this->fishingLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
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

    public function getLanguagesSpoken(): ?array
    {
        return $this->languagesSpoken;
    }

    public function setLanguagesSpoken(?array $languagesSpoken): static
    {
        $this->languagesSpoken = $languagesSpoken;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getBoatingLicenseNumber(): ?string
    {
        return $this->boatingLicenseNumber;
    }

    public function setBoatingLicenseNumber(?string $boatingLicenseNumber): static
    {
        $this->boatingLicenseNumber = $boatingLicenseNumber;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(?string $insuranceNumber): static
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getActivityType(): ?string
    {
        return $this->activityType;
    }

    public function setActivityType(?string $activityType): static
    {
        $this->activityType = $activityType;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(?string $siretNumber): static
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getCommerceRegisterNumber(): ?string
    {
        return $this->commerceRegisterNumber;
    }

    public function setCommerceRegisterNumber(string $commerceRegisterNumber): static
    {
        $this->commerceRegisterNumber = $commerceRegisterNumber;

        return $this;
    }

    public function getSalt(): ?string
    {
        // Pas nécessaire si vous utilisez un algorithme de hachage moderne
        return null;
    }

    public function getUsername(): string
    {
        // Utilisez généralement l'email comme identifiant
        return $this->email;
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
            $reservation->setOwner($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getOwner() === $this) {
                $reservation->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FishingTrip>
     */
    public function getFishingTrips(): Collection
    {
        return $this->fishingTrips;
    }

    public function addFishingTrip(FishingTrip $fishingTrip): static
    {
        if (!$this->fishingTrips->contains($fishingTrip)) {
            $this->fishingTrips->add($fishingTrip);
            $fishingTrip->setOwner($this);
        }

        return $this;
    }

    public function removeFishingTrip(FishingTrip $fishingTrip): static
    {
        if ($this->fishingTrips->removeElement($fishingTrip)) {
            // set the owning side to null (unless already changed)
            if ($fishingTrip->getOwner() === $this) {
                $fishingTrip->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Boat>
     */
    public function getBoats(): Collection
    {
        return $this->boats;
    }

    public function addBoat(Boat $boat): static
    {
        if (!$this->boats->contains($boat)) {
            $this->boats->add($boat);
            $boat->setOwner($this);
        }

        return $this;
    }

    public function removeBoat(Boat $boat): static
    {
        if ($this->boats->removeElement($boat)) {
            // set the owning side to null (unless already changed)
            if ($boat->getOwner() === $this) {
                $boat->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FishingLog>
     */
    public function getFishingLogs(): Collection
    {
        return $this->fishingLogs;
    }

    public function addFishingLog(FishingLog $fishingLog): static
    {
        if (!$this->fishingLogs->contains($fishingLog)) {
            $this->fishingLogs->add($fishingLog);
            $fishingLog->setOwner($this);
        }

        return $this;
    }

    public function removeFishingLog(FishingLog $fishingLog): static
    {
        if ($this->fishingLogs->removeElement($fishingLog)) {
            // set the owning side to null (unless already changed)
            if ($fishingLog->getOwner() === $this) {
                $fishingLog->setOwner(null);
            }
        }

        return $this;
    }
}

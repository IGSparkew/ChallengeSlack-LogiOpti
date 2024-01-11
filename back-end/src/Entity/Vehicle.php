<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VehicleType $vehicle_type = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'vehicles')]
    private Collection $user;


    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Delivery::class)]
    private Collection $deliveries;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicle_type;
    }

    public function setVehicleType(?VehicleType $vehicle_type): static
    {
        $this->vehicle_type = $vehicle_type;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);
        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->setVehicle($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getVehicle() === $this) {
                $delivery->setVehicle(null);
            }
        }

        return $this;
    }

    public function convertVehicleEntityToArray(Vehicle $vehicle): array
    {
        $vehicleType = new VehicleType();
        $vehicleArray = [
            'id' => $vehicle->getId(),
            'vehicleType' => $vehicle->getVehicleType() ? $vehicleType->convertVehicleTypeEntityToArray($vehicle->getVehicleType()) : null,
        ];

        return $vehicleArray;
    }
}

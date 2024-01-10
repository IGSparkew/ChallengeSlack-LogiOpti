<?php

namespace App\Entity;

use App\Repository\VehicleTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleTypeRepository::class)]
class VehicleType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $kilometer_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $average_comsumption = null;

    #[ORM\OneToMany(mappedBy: 'vehicle_type', targetEntity: Vehicle::class)]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getKilometerCost(): ?string
    {
        return $this->kilometer_cost;
    }

    public function setKilometerCost(?string $kilometer_cost): static
    {
        $this->kilometer_cost = $kilometer_cost;

        return $this;
    }

    public function getAverageComsumption(): ?string
    {
        return $this->average_comsumption;
    }

    public function setAverageComsumption(?string $average_comsumption): static
    {
        $this->average_comsumption = $average_comsumption;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setVehicleType($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getVehicleType() === $this) {
                $vehicle->setVehicleType(null);
            }
        }

        return $this;
    }
}

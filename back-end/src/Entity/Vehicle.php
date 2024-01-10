<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_load = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $kilometer_cost = null;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Delivery::class)]
    private Collection $deliveries;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $average_comsumption = null;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
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

    public function getMaxLoad(): ?int
    {
        return $this->max_load;
    }

    public function setMaxLoad(?int $max_load): static
    {
        $this->max_load = $max_load;

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

    public function getAverageComsumption(): ?string
    {
        return $this->average_comsumption;
    }

    public function setAverageComsumption(?string $average_comsumption): static
    {
        $this->average_comsumption = $average_comsumption;

        return $this;
    }
}

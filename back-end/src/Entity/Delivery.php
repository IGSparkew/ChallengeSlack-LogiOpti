<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $end_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 10, nullable: true)]
    private ?string $toll_cost = null;

    #[ORM\Column(length: 255)]
    private ?string $start_location = null;

    #[ORM\Column(length: 255)]
    private ?string $end_location = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 10, nullable: true)]
    private ?string $energy_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 10, nullable: true)]
    private ?string $using_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 10, nullable: true)]
    private ?string $distance = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payload = null;

    #[ORM\Column(length: 4000000000, nullable: true)]
    private ?string $array_coordinates = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicle $vehicle = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $working_time_cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getTollCost(): ?string
    {
        return $this->toll_cost;
    }

    public function setTollCost(?string $toll_cost): static
    {
        $this->toll_cost = $toll_cost;

        return $this;
    }

    public function getStartLocation(): ?string
    {
        return $this->start_location;
    }

    public function setStartLocation(string $start_location): static
    {
        $this->start_location = $start_location;

        return $this;
    }

    public function getEndLocation(): ?string
    {
        return $this->end_location;
    }

    public function setEndLocation(string $end_location): static
    {
        $this->end_location = $end_location;

        return $this;
    }

    public function getEnergyCost(): ?string
    {
        return $this->energy_cost;
    }

    public function setEnergyCost(?string $energy_cost): static
    {
        $this->energy_cost = $energy_cost;

        return $this;
    }

    public function getUsingCost(): ?string
    {
        return $this->using_cost;
    }

    public function setUsingCost(?string $using_cost): static
    {
        $this->using_cost = $using_cost;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(?string $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    public function setTime(?\DateTime $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(?string $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function getArrayCoordinates(): ?string
    {
        return $this->array_coordinates;
    }

    public function setArrayCoordinates(?string $array_coordinates): static
    {
        $this->array_coordinates = $array_coordinates;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getWorkingTimeCost(): ?string
    {
        return $this->working_time_cost;
    }

    public function setWorkingTimeCost(?string $working_time_cost): static
    {
        $this->working_time_cost = $working_time_cost;

        return $this;
    }
}

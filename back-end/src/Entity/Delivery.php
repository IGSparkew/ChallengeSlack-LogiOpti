<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;


#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery
{
    const Status = [
        0 => 'Upcoming',
        1 => 'Pending',
        2 => 'Finished'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $end_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $toll_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $energy_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $using_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $distance = null;
d
    #[ORM\Column(length: 4000000000, nullable: true)]
    private ?string $array_coordinates = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $working_time_cost = null;

    #[ORM\Column(nullable: true)]
    private ?int $Time = null;

    #[ORM\Column(nullable: true)]
    private ?int $Status = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?User $user = null;

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
        return $this->Status;
    }

    public function setStatus(?string $Status): static
    {
        $this->Status = $Status;

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

    public function getTime(): ?int
    {
        return $this->Time;
    }

    public function setTime(?int $Time): static
    {
        $this->Time = $Time;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function convertDeliveryEntityToArray(Delivery $delivery, ManagerRegistry $doctrine): array
    {
        $vehicle = new Vehicle();
        $user = new User();
        $deliveryAddress = $doctrine->getRepository(DeliveryAddress::class)->find($delivery->getId());
        $address = new Address();
        $status = $delivery->getStatus();
        if ($delivery->getStartDate()->format('Y-m-d') > date('Y-m-d') && $status == 0) {
            $status = 1;
        }
        $deliveryArray = [
            'id' => $delivery->getId(),
            'start_date' => $delivery->getStartDate(),
            'end_date' => $delivery->getEndDate(),
            'toll_cost' => $delivery->getTollCost(),
            'energy_cost' => $delivery->getEnergyCost(),
            'using_cost' => $delivery->getUsingCost(),
            'distance' => $delivery->getDistance(),
            'array_coordinates' => json_decode($delivery->getArrayCoordinates(), true),
            'working_time_cost' => $delivery->getWorkingTimeCost(),
            'Time' => $delivery->getTime(),
            'Status' => self::Status[$status],
            'startAddress' => $address->convertAddressEntityToArray($deliveryAddress->getAddressStart()),
            'endAddress' => $address->convertAddressEntityToArray($deliveryAddress->getaddressEnd()),
            'vehicle' => $delivery->getVehicle() ? $vehicle->convertVehicleEntityToArray($delivery->getVehicle()) : null,
            'user' => $delivery->getUser() ? $user->convertUserEntityToArray($delivery->getUser()) : null,
        ];

        return $deliveryArray;
    }

}

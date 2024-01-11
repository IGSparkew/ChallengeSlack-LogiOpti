<?php

namespace App\Entity;

use App\Repository\DeliveryAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryAddressRepository::class)]
class DeliveryAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Delivery $delivery = null;

    #[ORM\ManyToOne(inversedBy: 'address_end')]
    private ?Address $address_start = null;

    #[ORM\ManyToOne(inversedBy: 'deliveryAddresses')]
    private ?Address $address_end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getAddressStart(): ?Address
    {
        return $this->address_start;
    }

    public function setAddressStart(?Address $address_start): static
    {
        $this->address_start = $address_start;

        return $this;
    }

    public function getAddressEnd(): ?Address
    {
        return $this->address_end;
    }

    public function setAddressEnd(?Address $address_end): static
    {
        $this->address_end = $address_end;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 10)]
    private ?string $postal_code = null;

    #[ORM\OneToMany(mappedBy: 'address_start', targetEntity: DeliveryAddress::class)]
    private Collection $addressStart;

    #[ORM\OneToMany(mappedBy: 'address_end', targetEntity: DeliveryAddress::class)]
    private Collection $addressEnd;

    public function __construct()
    {
        $this->addressStart = new ArrayCollection();
        $this->addressEnd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postal_code = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, DeliveryAddress>
     */
    public function getAddressStart(): Collection
    {
        return $this->addressStart;
    }

    public function addAddressStart(DeliveryAddress $addressStart): static
    {
        if (!$this->addressStart->contains($addressStart)) {
            $this->addressStart->add($addressStart);
            $addressStart->setAddressStart($this);
        }

        return $this;
    }

    public function removeAddressStart(DeliveryAddress $addressStart): static
    {
        if ($this->addressStart->removeElement($addressStart)) {
            // set the owning side to null (unless already changed)
            if ($addressStart->getAddressStart() === $this) {
                $addressStart->setAddressStart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DeliveryAddress>
     */
    public function getaddressEnd(): Collection
    {
        return $this->addressEnd;
    }

    public function addAddressEnd(DeliveryAddress $addressEnd): static
    {
        if (!$this->addressEnd->contains($addressEnd)) {
            $this->addressEnd->add($addressEnd);
            $addressEnd->setAddressEnd($this);
        }

        return $this;
    }

    public function removeAddressEnd(DeliveryAddress $addressEnd): static
    {
        if ($this->addressEnd->removeElement($addressEnd)) {
            // set the owning side to null (unless already changed)
            if ($addressEnd->getAddressEnd() === $this) {
                $addressEnd->setAddressEnd(null);
            }
        }

        return $this;
    }

    public function convertAddressEntityToArray(Address $address): array
    {
        $addressArray = [
            'id' => $address->getId(),
            'country' => $address->getCountry(),
            'region' => $address->getRegion(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'postalCode' => $address->getPostalCode()
        ];

        return $addressArray;
    }
}

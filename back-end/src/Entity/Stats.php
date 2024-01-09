<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatsRepository::class)]
class Stats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $field_x = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $field_y = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $max_x = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $max_y = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $step_x = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $step_y = null;

    #[ORM\Column(nullable: true)]
    private ?array $stats_values = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldX(): ?string
    {
        return $this->field_x;
    }

    public function setFieldX(?string $field_x): static
    {
        $this->field_x = $field_x;

        return $this;
    }

    public function getFieldY(): ?string
    {
        return $this->field_y;
    }

    public function setFieldY(?string $field_y): static
    {
        $this->field_y = $field_y;

        return $this;
    }

    public function getMaxX(): ?string
    {
        return $this->max_x;
    }

    public function setMaxX(?string $max_x): static
    {
        $this->max_x = $max_x;

        return $this;
    }

    public function getMaxY(): ?string
    {
        return $this->max_y;
    }

    public function setMaxY(?string $max_y): static
    {
        $this->max_y = $max_y;

        return $this;
    }

    public function getStepX(): ?string
    {
        return $this->step_x;
    }

    public function setStepX(?string $step_x): static
    {
        $this->step_x = $step_x;

        return $this;
    }

    public function getStepY(): ?string
    {
        return $this->step_y;
    }

    public function setStepY(?string $step_y): static
    {
        $this->step_y = $step_y;

        return $this;
    }

    public function getStatsValues(): ?array
    {
        return $this->stats_values;
    }

    public function setStatsValues(?array $stats_values): static
    {
        $this->stats_values = $stats_values;

        return $this;
    }
}

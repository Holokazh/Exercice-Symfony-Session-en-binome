<?php

namespace App\Entity;

use App\Repository\DurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DurationRepository::class)
 */
class Duration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDay;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="durations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="durations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbDay(): ?int
    {
        return $this->nbDay;
    }

    public function setNbDay(int $nbDay): self
    {
        $this->nbDay = $nbDay;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }
}

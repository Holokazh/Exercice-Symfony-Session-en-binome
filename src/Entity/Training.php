<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 */
class Training
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="training", orphanRemoval=true)
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity=Duration::class, mappedBy="training", orphanRemoval=true)
     */
    private $durations;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->durations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    ///// METHODE MAGIQUE __toString /////
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setTraining($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTraining() === $this) {
                $session->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Duration[]
     */
    public function getDurations(): Collection
    {
        return $this->durations;
    }

    public function addDuration(Duration $duration): self
    {
        if (!$this->durations->contains($duration)) {
            $this->durations[] = $duration;
            $duration->setTraining($this);
        }

        return $this;
    }

    public function removeDuration(Duration $duration): self
    {
        if ($this->durations->removeElement($duration)) {
            // set the owning side to null (unless already changed)
            if ($duration->getTraining() === $this) {
                $duration->setTraining(null);
            }
        }

        return $this;
    }
}

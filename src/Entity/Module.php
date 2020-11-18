<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
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
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Category;

    /**
     * @ORM\OneToMany(targetEntity=Duration::class, mappedBy="module", orphanRemoval=true)
     */
    private $durations;

    public function __construct()
    {
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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

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
            $duration->setModule($this);
        }

        return $this;
    }

    public function removeDuration(Duration $duration): self
    {
        if ($this->durations->removeElement($duration)) {
            // set the owning side to null (unless already changed)
            if ($duration->getModule() === $this) {
                $duration->setModule(null);
            }
        }

        return $this;
    }
}

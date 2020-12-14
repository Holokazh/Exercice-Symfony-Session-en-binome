<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min = 1, 
     * minMessage = "Il doit y avoir au moins une place.")
     */
    private $nbSpace;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan("today",
     * message = "La date de début doit être supérieur à la date d'aujourd'hui.")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath = "dateStart",
     * message = "La date de fin doit être supérieure à la date de début.")
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    /**
     * @ORM\ManyToMany(targetEntity=Student::class, inversedBy="sessions")
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbSpace(): ?int
    {
        return $this->nbSpace;
    }

    public function setNbSpace(int $nbSpace): self
    {
        $this->nbSpace = $nbSpace;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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

    ///// METHODE MAGIQUE __toString /////
    public function __toString()
    {
        return $this->getTraining() . ' du ' . $this->getDateStart() . ' au ' . $this->getDateEnd();
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        $this->students->removeElement($student);

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->getDateStart()->diff($this->getDateEnd())->m;
    }
}

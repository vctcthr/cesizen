<?php

namespace App\Entity;

use App\Repository\BreathingExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreathingExerciseRepository::class)]
class BreathingExercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $inhaleDuration = null;

    #[ORM\Column(length: 255)]
    private ?string $holdDuration = null;

    #[ORM\Column(length: 255)]
    private ?string $exhaleDuration = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    /**
     * @var Collection<int, BreathingSession>
     */
    #[ORM\OneToMany(targetEntity: BreathingSession::class, mappedBy: 'exercise')]
    private Collection $breathingSessions;

    public function __construct()
    {
        $this->breathingSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getInhaleDuration(): ?string
    {
        return $this->inhaleDuration;
    }

    public function setInhaleDuration(string $inhaleDuration): static
    {
        $this->inhaleDuration = $inhaleDuration;

        return $this;
    }

    public function getHoldDuration(): ?string
    {
        return $this->holdDuration;
    }

    public function setHoldDuration(string $holdDuration): static
    {
        $this->holdDuration = $holdDuration;

        return $this;
    }

    public function getExhaleDuration(): ?string
    {
        return $this->exhaleDuration;
    }

    public function setExhaleDuration(string $exhaleDuration): static
    {
        $this->exhaleDuration = $exhaleDuration;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, BreathingSession>
     */
    public function getBreathingSessions(): Collection
    {
        return $this->breathingSessions;
    }

    public function addBreathingSession(BreathingSession $breathingSession): static
    {
        if (!$this->breathingSessions->contains($breathingSession)) {
            $this->breathingSessions->add($breathingSession);
            $breathingSession->setExercise($this);
        }

        return $this;
    }

    public function removeBreathingSession(BreathingSession $breathingSession): static
    {
        if ($this->breathingSessions->removeElement($breathingSession)) {
            // set the owning side to null (unless already changed)
            if ($breathingSession->getExercise() === $this) {
                $breathingSession->setExercise(null);
            }
        }

        return $this;
    }
}

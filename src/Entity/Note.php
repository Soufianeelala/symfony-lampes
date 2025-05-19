<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $NoteLamp = null;

    #[ORM\ManyToOne(inversedBy: 'NoteUser')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'LampNote')]
    private ?Lamp $lamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteLamp(): ?float
    {
        return $this->NoteLamp;
    }

    public function setNoteLamp(float $NoteLamp): static
    {
        $this->NoteLamp = $NoteLamp;

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

    public function getLamp(): ?Lamp
    {
        return $this->lamp;
    }

    public function setLamp(?Lamp $lamp): static
    {
        $this->lamp = $lamp;

        return $this;
    }
}

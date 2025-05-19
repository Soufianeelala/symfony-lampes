<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Lamp>
     */
    #[ORM\OneToMany(targetEntity: Lamp::class, mappedBy: 'user')]
    private Collection $lamps;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $resetTokenExpiresAt = null;

    /**
     * @var Collection<int, comment>
     */
    #[ORM\OneToMany(targetEntity: comment::class, mappedBy: 'user')]
    private Collection $userComment;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'user')]
    private Collection $NoteUser;


   
    public function __construct()
    {
        $this->lamps = new ArrayCollection();
        $this->userComment = new ArrayCollection();
        $this->NoteUser = new ArrayCollection();
       
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clear any temporary sensitive data
    }

    /**
     * @return Collection<int, Lamp>
     */
    public function getLamps(): Collection
    {
        return $this->lamps;
    }

    public function addLamp(Lamp $lamp): static
    {
        if (!$this->lamps->contains($lamp)) {
            $this->lamps->add($lamp);
            $lamp->setUser($this);
        }

        return $this;
    }

    public function removeLamp(Lamp $lamp): static
    {
        if ($this->lamps->removeElement($lamp)) {
            // set the owning side to null (unless already changed)
            if ($lamp->getUser() === $this) {
                $lamp->setUser(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Note>
    //  */
    // public function getNotes(): Collection
    // {
    //     return $this->notes;
    // }

    // public function addNote(Note $note): static
    // {
    //     if (!$this->notes->contains($note)) {
    //         $this->notes->add($note);
    //         $note->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeNote(Note $note): static
    // {
    //     if ($this->notes->removeElement($note)) {
    //         // set the owning side to null (unless already changed)
    //         if ($note->getUser() === $this) {
    //             $note->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getResetTokenExpiresAt(): ?\DateTimeInterface
    {
        return $this->resetTokenExpiresAt;
    }

    public function setResetTokenExpiresAt(?\DateTimeInterface $resetTokenExpiresAt): self
    {
        $this->resetTokenExpiresAt = $resetTokenExpiresAt;

        return $this;
    }

    public function isResetTokenValid(): bool
    {
        return $this->resetTokenExpiresAt > new \DateTime();
    }

    /**
     * @return Collection<int, comment>
     */
    public function getUserComment(): Collection
    {
        return $this->userComment;
    }

    public function addUserComment(comment $userComment): static
    {
        if (!$this->userComment->contains($userComment)) {
            $this->userComment->add($userComment);
            $userComment->setUser($this);
        }

        return $this;
    }

    public function removeUserComment(comment $userComment): static
    {
        if ($this->userComment->removeElement($userComment)) {
            // set the owning side to null (unless already changed)
            if ($userComment->getUser() === $this) {
                $userComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNoteUser(): Collection
    {
        return $this->NoteUser;
    }

    public function addNoteUser(Note $noteUser): static
    {
        if (!$this->NoteUser->contains($noteUser)) {
            $this->NoteUser->add($noteUser);
            $noteUser->setUser($this);
        }

        return $this;
    }

    public function removeNoteUser(Note $noteUser): static
    {
        if ($this->NoteUser->removeElement($noteUser)) {
            // set the owning side to null (unless already changed)
            if ($noteUser->getUser() === $this) {
                $noteUser->setUser(null);
            }
        }

        return $this;
    }

   
}


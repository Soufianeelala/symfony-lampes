<?php 

namespace App\Entity;

use App\Repository\LampRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: LampRepository::class)]
class Lamp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(name: 'image_name', type: 'string', nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'float')]
    private ?float $value = null;
    public function getValue(): ?float
{
    return $this->value;
}

public function setValue(float $value): static
{
    $this->value = $value;
    return $this;
}

    #[ORM\Column(type: 'text')]
    private ?string $description = null;
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    // #[ORM\OneToMany(mappedBy: 'lamp', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    // private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'lamps')]
    private ?User $user = null;

    /**
     * @var Collection<int, comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'lamp')]
    private Collection $lampComment;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'lamp')]
    private Collection $LampNote;

    public function __construct()
    {
        $this->lampComment = new ArrayCollection();
        $this->LampNote = new ArrayCollection();
    }

   

    // public function __construct()
    // {
    //     $this->comments = new ArrayCollection();
    
    // }

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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    // public function getComments(): Collection
    // {
    //     return $this->comments;
    // }

    // public function addComment(Comment $comment): static
    // {
    //     if (!$this->comments->contains($comment)) {
    //         $this->comments->add($comment);
    //         $comment->setLamp($this);
    //     }

    //     return $this;
    // }

    // public function removeComment(Comment $comment): static
    // {
    //     if ($this->comments->removeElement($comment)) {
    //         if ($comment->getLamp() === $this) {
    //             $comment->setLamp(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function getNotes(): Collection
    // {
    //     return $this->notes;
    // }

    // public function addNote(Note $note): static
    // {
    //     if (!$this->notes->contains($note)) {
    //         $this->notes->add($note);
    //         $note->setLamp($this);
    //     }

    //     return $this;
    // }

    // public function removeNote(Note $note): static
    // {
    //     if ($this->notes->removeElement($note)) {
    //         if ($note->getLamp() === $this) {
    //             $note->setLamp(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, comment>
     */
    public function getLampComment(): Collection
    {
        return $this->lampComment;
    }

    public function addLampComment(Comment $lampComment): static
    {
        if (!$this->lampComment->contains($lampComment)) {
            $this->lampComment->add($lampComment);
            $lampComment->setLamp($this);
        }

        return $this;
    }

    public function removeLampComment(Comment $lampComment): static
    {
        if ($this->lampComment->removeElement($lampComment)) {
            // set the owning side to null (unless already changed)
            if ($lampComment->getLamp() === $this) {
                $lampComment->setLamp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getLampNote(): Collection
    {
        return $this->LampNote;
    }

    public function addLampNote(Note $lampNote): static
    {
        if (!$this->LampNote->contains($lampNote)) {
            $this->LampNote->add($lampNote);
            $lampNote->setLamp($this);
        }

        return $this;
    }

    public function removeLampNote(Note $lampNote): static
    {
        if ($this->LampNote->removeElement($lampNote)) {
            // set the owning side to null (unless already changed)
            if ($lampNote->getLamp() === $this) {
                $lampNote->setLamp(null);
            }
        }

        return $this;
    }


   
}

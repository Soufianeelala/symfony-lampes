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
    // Définition de la clé primaire
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

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $creates_at = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'lamp')]
    private Collection $lamp_id;

    #[ORM\ManyToOne(inversedBy: 'lamps')]
    private ?User $user = null;

    public function __construct()
    {
        $this->lamp_id = new ArrayCollection();
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

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatesAt(): ?\DateTimeImmutable
    {
        return $this->creates_at;
    }

    public function setCreatesAt(\DateTimeImmutable $creates_at): static
    {
        $this->creates_at = $creates_at;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getLampId(): Collection
    {
        return $this->lamp_id;
    }

    public function addLampId(Comment $lampId): static
    {
        if (!$this->lamp_id->contains($lampId)) {
            $this->lamp_id->add($lampId);
            $lampId->setLamp($this);
        }
        return $this;
    }

    public function removeLampId(Comment $lampId): static
    {
        if ($this->lamp_id->removeElement($lampId)) {
            if ($lampId->getLamp() === $this) {
                $lampId->setLamp(null);
            }
        }
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
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'project:read:item']
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'project:read:list']
        ),
        new Post(
            denormalizationContext: ['groups' => 'project:write']
        ),
        new Delete()
    ]
)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['artist:read:item','project:read:item','project:read:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artist:read:item','project:read:item','project:write','project:read:list'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artist:read:item','project:read:item','project:write','project:read:list'])]
    private ?string $coverLink = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artist:read:item','project:read:item','project:write','project:read:list'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['artist:read:item','project:read:item','project:write','project:read:list'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[Groups(['project:read:item','project:write'])]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Title::class)]
    #[Groups(['project:read:item'])]
    private Collection $titles;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'projects',cascade:["persist"])]
    #[Groups(['project:read:item','project:write'])]
    private Collection $artists;

    public function __construct()
    {
        $this->titles = new ArrayCollection();
        $this->artists = new ArrayCollection();
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

    public function getCoverLink(): ?string
    {
        return $this->coverLink;
    }

    public function setCoverLink(string $coverLink): self
    {
        $this->coverLink = $coverLink;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Title>
     */
    public function getTitles(): Collection
    {
        return $this->titles;
    }

    public function addTitle(Title $title): self
    {
        if (!$this->titles->contains($title)) {
            $this->titles->add($title);
            $title->setProject($this);
        }

        return $this;
    }

    public function removeTitle(Title $title): self
    {
        if ($this->titles->removeElement($title)) {
            // set the owning side to null (unless already changed)
            if ($title->getProject() === $this) {
                $title->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->artists->removeElement($artist);

        return $this;
    }
}

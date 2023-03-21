<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: TitleRepository::class)]
#[ApiResource]
class Title
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['artist:read:item','project:read:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artist:read:item','project:read:item'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['artist:read:item','project:read:item'])]
    private ?string $lyrics = null;

    #[ORM\ManyToOne(inversedBy: 'titles')]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    #[Groups(['artist:read:item'])]
    private ?Project $project = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['artist:read:item','project:read:item'])]
    private array $interpreters = [];

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'features')]
    #[Groups(['project:read:item'])]
    private Collection $featurings;

    public function __construct()
    {
        $this->featurings = new ArrayCollection();
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

    public function getLyrics(): ?string
    {
        return $this->lyrics;
    }

    public function setLyrics(?string $lyrics): self
    {
        $this->lyrics = $lyrics;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }


    public function getInterpreters(): array
    {
        return $this->interpreters;
    }

    public function setInterpreters(?array $interpreters): self
    {
        $this->interpreters = $interpreters;

        return $this;
    }

    public function removeInterpreter(Artist $interpreter): self
    {
        $this->interpreters->removeElement($interpreter);

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getFeaturings(): Collection
    {
        return $this->featurings;
    }

    public function addFeaturing(Artist $featuring): self
    {
        if (!$this->featurings->contains($featuring)) {
            $this->featurings->add($featuring);
        }

        return $this;
    }

    public function removeFeaturing(Artist $featuring): self
    {
        $this->featurings->removeElement($featuring);

        return $this;
    }


}

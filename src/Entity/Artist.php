<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $photoLink = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'artists')]
    private Collection $projects;

    #[ORM\ManyToMany(targetEntity: Title::class, mappedBy: 'featurings')]
    private Collection $features;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->features = new ArrayCollection();
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

    public function getPhotoLink(): ?string
    {
        return $this->photoLink;
    }

    public function setPhotoLink(string $photoLink): self
    {
        $this->photoLink = $photoLink;

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


    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addArtist($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Title>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Title $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features->add($feature);
            $feature->addFeaturing($this);
        }

        return $this;
    }

    public function removeFeature(Title $feature): self
    {
        if ($this->features->removeElement($feature)) {
            $feature->removeFeaturing($this);
        }

        return $this;
    }
}
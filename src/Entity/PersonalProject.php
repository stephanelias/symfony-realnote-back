<?php

namespace App\Entity;

use App\Repository\PersonalProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalProjectRepository::class)]
class PersonalProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $artists = [];

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\OneToMany(mappedBy: 'personalProject', targetEntity: RankedTitle::class)]
    private Collection $rankedTitles;

    #[ORM\ManyToOne(inversedBy: 'personalProjects')]
    private ?User $user = null;

    public function __construct()
    {
        $this->rankedTitles = new ArrayCollection();
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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getArtists(): array
    {
        return $this->artists;
    }

    public function setArtists(array $artists): self
    {
        $this->artists = $artists;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, RankedTitle>
     */
    public function getRankedTitles(): Collection
    {
        return $this->rankedTitles;
    }

    public function addRankedTitle(RankedTitle $rankedTitle): self
    {
        if (!$this->rankedTitles->contains($rankedTitle)) {
            $this->rankedTitles->add($rankedTitle);
            $rankedTitle->setPersonalProject($this);
        }

        return $this;
    }

    public function removeRankedTitle(RankedTitle $rankedTitle): self
    {
        if ($this->rankedTitles->removeElement($rankedTitle)) {
            // set the owning side to null (unless already changed)
            if ($rankedTitle->getPersonalProject() === $this) {
                $rankedTitle->setPersonalProject(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

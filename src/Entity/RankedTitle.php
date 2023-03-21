<?php

namespace App\Entity;

use App\Repository\RankedTitleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RankedTitleRepository::class)]
class RankedTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lyricsRank = null;

    #[ORM\Column(length: 255)]
    private ?string $beatRank = null;

    #[ORM\Column(length: 255)]
    private ?string $flowRank = null;

    #[ORM\Column(length: 255)]
    private ?string $featsRank = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $feats = [];

    #[ORM\ManyToOne(inversedBy: 'rankedTitles')]
    private ?PersonalProject $personalProject = null;

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

    public function getLyricsRank(): ?string
    {
        return $this->lyricsRank;
    }

    public function setLyricsRank(string $lyricsRank): self
    {
        $this->lyricsRank = $lyricsRank;

        return $this;
    }

    public function getBeatRank(): ?string
    {
        return $this->beatRank;
    }

    public function setBeatRank(string $beatRank): self
    {
        $this->beatRank = $beatRank;

        return $this;
    }

    public function getFlowRank(): ?string
    {
        return $this->flowRank;
    }

    public function setFlowRank(string $flowRank): self
    {
        $this->flowRank = $flowRank;

        return $this;
    }

    public function getFeatsRank(): ?string
    {
        return $this->featsRank;
    }

    public function setFeatsRank(string $featsRank): self
    {
        $this->featsRank = $featsRank;

        return $this;
    }

    public function getFeats(): array
    {
        return $this->feats;
    }

    public function setFeats(?array $feats): self
    {
        $this->feats = $feats;

        return $this;
    }

    public function getPersonalProject(): ?PersonalProject
    {
        return $this->personalProject;
    }

    public function setPersonalProject(?PersonalProject $personalProject): self
    {
        $this->personalProject = $personalProject;

        return $this;
    }
}

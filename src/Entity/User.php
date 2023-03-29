<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\UserIdController;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username')]
#[ApiResource(
    operations: [
        new Post(processor: UserPasswordHasher::class),
        new Get(
            normalizationContext: ['groups' => 'user:read:item']
        ),
        new Patch(
            processor: UserPasswordHasher::class
        )
    ],

)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read:item'])]
    private ?string $username = null;

    #[ORM\Column]
    #[Groups(['user:read:item'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $spotifyToken = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $spotifyClientId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $spotifyClientSecret = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PersonalProject::class)]
    private Collection $personalProjects;

    public function __construct()
    {
        $this->personalProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSpotifyToken(): ?string
    {
        return $this->spotifyToken;
    }

    public function setSpotifyToken(?string $spotifyToken): self
    {
        $this->spotifyToken = $spotifyToken;

        return $this;
    }

    public function getSpotifyClientId(): ?string
    {
        return $this->spotifyClientId;
    }

    public function setSpotifyClientId(?string $spotifyClientId): self
    {
        $this->spotifyClientId = $spotifyClientId;

        return $this;
    }

    public function getSpotifyClientSecret(): ?string
    {
        return $this->spotifyClientSecret;
    }

    public function setSpotifyClientSecret(?string $spotifyClientSecret): self
    {
        $this->spotifyClientSecret = $spotifyClientSecret;

        return $this;
    }

    /**
     * @return Collection<int, PersonalProject>
     */
    public function getPersonalProjects(): Collection
    {
        return $this->personalProjects;
    }

    public function addPersonalProject(PersonalProject $personalProject): self
    {
        if (!$this->personalProjects->contains($personalProject)) {
            $this->personalProjects->add($personalProject);
            $personalProject->setUser($this);
        }

        return $this;
    }

    public function removePersonalProject(PersonalProject $personalProject): self
    {
        if ($this->personalProjects->removeElement($personalProject)) {
            // set the owning side to null (unless already changed)
            if ($personalProject->getUser() === $this) {
                $personalProject->setUser(null);
            }
        }

        return $this;
    }
}

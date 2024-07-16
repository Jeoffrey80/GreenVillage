<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommercialRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: CommercialRepository::class)]
class Commercial implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'commercial', targetEntity: Client::class, orphanRemoval: true)]
    private Collection $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresse_mail;
    }

    public function setAdresseMail(string $adresse_mail): static
    {
        $this->adresse_mail = $adresse_mail;

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

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setCommercial($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getCommercial() === $this) {
                $client->setCommercial(null);
            }
        }

        return $this;
    }

    // Méthode pour hacher le mot de passe
    public function hashPassword(UserPasswordHasherInterface $hasher): void
    {
        $this->password = $hasher->hashPassword(new class ($this->password) implements PasswordAuthenticatedUserInterface {
            private $password;

            public function __construct($password)
            {
                $this->password = $password;
            }

            public function getPassword(): ?string
            {
                return $this->password;
            }

            public function getSalt(): ?string
            {
                return null;
            }

            public function eraseCredentials(): void
            {
                // No-op
            }

            public function getRoles(): array
            {
                return [];
            }

            public function getUserIdentifier(): string
            {
                return '';
            }
        }, $this->password);
    }

    public function getRoles(): array
    {
        $roles = [$this->role ?: 'ROLE_USER'];

        // garantit que chaque utilisateur a au moins ROLE_USER
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function getSalt(): ?string
    {
        // non nécessaire pour les applications utilisant bcrypt ou argon2i
        return null;
    }

    public function getUsername(): string
    {
        return (string) $this->adresse_mail;
    }

    public function eraseCredentials()
    {
        // Si vous stockez des données temporaires ou sensibles dans l'utilisateur, effacez-les ici
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->adresse_mail;
    }




}

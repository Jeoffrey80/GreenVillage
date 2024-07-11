<?php
namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_mail = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_livraison = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_facturation = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $type_client = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $coefficient = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable:true)]
    private ?string $reduc_pro = null;

    #[ORM\ManyToOne(targetEntity: Commercial::class, inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commercial $commercial = null;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getEmail(): ?string
    {
        return $this->adresse_mail;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivraison(string $adresse_livraison): static
    {
        $this->adresse_livraison = $adresse_livraison;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation(string $adresse_facturation): static
    {
        $this->adresse_facturation = $adresse_facturation;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isTypeClient(): ?bool
    {
        return $this->type_client;
    }

    public function setTypeClient(bool $type_client): static
    {
        $this->type_client = $type_client;

        return $this;
    }

    public function getCoefficient(): ?string
    {
        return $this->coefficient;
    }

    public function setCoefficient(string $coefficient): static
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getReducPro(): ?string
    {
        return $this->reduc_pro;
    }

    public function setReducPro(string $reduc_pro): self
    {
        $this->reduc_pro = $reduc_pro;

        return $this;
    }

    // Méthodes requises par UserInterface et PasswordAuthenticatedUserInterface

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
    public function getCommercial(): ?Commercial
    {
        return $this->commercial;
    }

    public function setCommercial(?Commercial $commercial): static
    {
        $this->commercial = $commercial;

        return $this;
    }
}

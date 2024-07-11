<?php
namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut_commande = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_commande = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant_tot = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    private Collection $produits;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Livraison::class, orphanRemoval: true)]
    private Collection $livraisons;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Bonlivraison::class, orphanRemoval: true)]
    private Collection $bonlivraisons;

    #[ORM\OneToOne(mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private ?Facture $facture = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
        $this->bonlivraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutCommande(): ?\DateTimeInterface
    {
        return $this->date_debut_commande;
    }

    public function setDateDebutCommande(\DateTimeInterface $date_debut_commande): static
    {
        $this->date_debut_commande = $date_debut_commande;

        return $this;
    }

    public function getNomCommande(): ?string
    {
        return $this->nom_commande;
    }

    public function setNomCommande(string $nom_commande): static
    {
        $this->nom_commande = $nom_commande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMontantTot(): ?string
    {
        return $this->montant_tot;
    }

    public function setMontantTot(string $montant_tot): static
    {
        $this->montant_tot = $montant_tot;

        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): static
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setCommande($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): static
    {
        if ($this->livraisons->removeElement($livraison)) {
            if ($livraison->getCommande() === $this) {
                $livraison->setCommande(null);
            }
        }

        return $this;
    }

    public function getBonlivraisons(): Collection
    {
        return $this->bonlivraisons;
    }

    public function addBonlivraison(Bonlivraison $bonlivraison): static
    {
        if (!$this->bonlivraisons->contains($bonlivraison)) {
            $this->bonlivraisons->add($bonlivraison);
            $bonlivraison->setCommande($this);
        }

        return $this;
    }

    public function removeBonlivraison(Bonlivraison $bonlivraison): static
    {
        if ($this->bonlivraisons->removeElement($bonlivraison)) {
            if ($bonlivraison->getCommande() === $this) {
                $bonlivraison->setCommande(null);
            }
        }

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): static
    {
        if ($facture === null && $this->facture !== null) {
            $this->facture->setCommande(null);
        }

        if ($facture !== null && $facture->getCommande() !== $this) {
            $facture->setCommande($this);
        }

        $this->facture = $facture;

        return $this;
    }
}

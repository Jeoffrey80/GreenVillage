<?php
namespace App\Entity;

use App\Repository\BonlivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BonlivraisonRepository::class)]
class Bonlivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_bon = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix_unitaire = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $pu_hors_taxe = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_ht = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'bonlivraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroBon(): ?int
    {
        return $this->numero_bon;
    }

    public function setNumeroBon(int $numero_bon): static
    {
        $this->numero_bon = $numero_bon;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(string $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getPuHorsTaxe(): ?string
    {
        return $this->pu_hors_taxe;
    }

    public function setPuHorsTaxe(string $pu_hors_taxe): static
    {
        $this->pu_hors_taxe = $pu_hors_taxe;

        return $this;
    }

    public function getTotalHt(): ?string
    {
        return $this->total_ht;
    }

    public function setTotalHt(string $total_ht): static
    {
        $this->total_ht = $total_ht;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }
}

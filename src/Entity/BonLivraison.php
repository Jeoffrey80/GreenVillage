<?php

namespace App\Entity;

use App\Repository\BonLivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonLivraisonRepository::class)]
class BonLivraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numbon = null;

    #[ORM\Column(length: 255)]
    private ?string $detailbon = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix_unitaireHT = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalHT = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'bonLivraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumbon(): ?int
    {
        return $this->numbon;
    }

    public function setNumbon(int $numbon): static
    {
        $this->numbon = $numbon;

        return $this;
    }

    public function getDetailbon(): ?string
    {
        return $this->detailbon;
    }

    public function setDetailbon(string $detailbon): static
    {
        $this->detailbon = $detailbon;

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

    public function getPrixUnitaireHT(): ?string
    {
        return $this->prix_unitaireHT;
    }

    public function setPrixUnitaireHT(string $prix_unitaireHT): static
    {
        $this->prix_unitaireHT = $prix_unitaireHT;

        return $this;
    }

    public function getTotalHT(): ?string
    {
        return $this->totalHT;
    }

    public function setTotalHT(string $totalHT): static
    {
        $this->totalHT = $totalHT;

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

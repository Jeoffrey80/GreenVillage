<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
}

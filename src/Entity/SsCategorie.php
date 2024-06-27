<?php

namespace App\Entity;

use App\Repository\SsCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SsCategorieRepository::class)]
class SsCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre_sscategorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreSscategorie(): ?string
    {
        return $this->titre_sscategorie;
    }

    public function setTitreSscategorie(string $titre_sscategorie): static
    {
        $this->titre_sscategorie = $titre_sscategorie;

        return $this;
    }
}

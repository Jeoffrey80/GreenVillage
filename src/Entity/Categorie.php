<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre_categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $description_categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $image_categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCategorie(): ?string
    {
        return $this->titre_categorie;
    }

    public function setTitreCategorie(string $titre_categorie): static
    {
        $this->titre_categorie = $titre_categorie;

        return $this;
    }

    public function getDescriptionCategorie(): ?string
    {
        return $this->description_categorie;
    }

    public function setDescriptionCategorie(string $description_categorie): static
    {
        $this->description_categorie = $description_categorie;

        return $this;
    }

    public function getImageCategorie(): ?string
    {
        return $this->image_categorie;
    }

    public function setImageCategorie(string $image_categorie): static
    {
        $this->image_categorie = $image_categorie;

        return $this;
    }
}

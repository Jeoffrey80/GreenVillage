<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $description_categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $image_categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $type_categorie = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'Categorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $categorie = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'categorie')]
    private Collection $Categorie;

    public function __construct()
    {
        $this->Categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): static
    {
        $this->nom_categorie = $nom_categorie;

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

    public function getTypeCategorie(): ?string
    {
        return $this->type_categorie;
    }

    public function setTypeCategorie(string $type_categorie): static
    {
        $this->type_categorie = $type_categorie;

        return $this;
    }

    public function getCategorie(): ?self
    {
        return $this->categorie;
    }

    public function setCategorie(?self $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function addCategorie(self $categorie): static
    {
        if (!$this->Categorie->contains($categorie)) {
            $this->Categorie->add($categorie);
            $categorie->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorie(self $categorie): static
    {
        if ($this->Categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getCategorie() === $this) {
                $categorie->setCategorie(null);
            }
        }

        return $this;
    }
}

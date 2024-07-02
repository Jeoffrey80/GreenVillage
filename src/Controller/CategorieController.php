<?php
// src/Controller/CategorieController.php

namespace App\Controller;

use App\Entity\Famille;
use App\Entity\Type;
use App\Entity\SousType;
use App\Entity\Modele;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CategorieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    
    #[Route("/categories", name:"categories")]
    public function categories(): Response
    {
        $familles = $this->entityManager->getRepository(Famille::class)->findAll();

        return $this->render('categories/familles.html.twig', [
            'familles' => $familles,
        ]);
    }

    
    #[Route("/categories/{familleId}/types", name:"types")]

    public function types(int $familleId): Response
    {
        $famille = $this->entityManager->getRepository(Famille::class)->find($familleId);
        $types = $this->entityManager->getRepository(Type::class)->findBy(['famille' => $famille]);

        return $this->render('categories/types.html.twig', [
            'famille' => $famille,
            'types' => $types,
        ]);
    }

    
    #[Route("/categories/{familleId}/types/{typeId}/sous_types", name:"sous_types")]
    public function sousTypes(int $typeId): Response
    {
        $type = $this->entityManager->getRepository(Type::class)->find($typeId);
        $sousTypes = $this->entityManager->getRepository(SousType::class)->findBy(['type' => $type]);

        return $this->render('categories/sous_types.html.twig', [
            'type' => $type,
            'sousTypes' => $sousTypes,
        ]);
    }

    
    #[Route("/categories/{familleId}/types/{typeId}/sous_types/{sousTypeId}/modeles", name:"modeles")]
    public function modeles(int $sousTypeId): Response
    {
        $sousType = $this->entityManager->getRepository(SousType::class)->find($sousTypeId);
        $modeles = $this->entityManager->getRepository(Modele::class)->findBy(['sousType' => $sousType]);

        return $this->render('categories/modeles.html.twig', [
            'sousType' => $sousType,
            'modeles' => $modeles,
        ]);
    }

    
    #[Route("/categories/{familleId}/types/{typeId}/sous_types/{sousTypeId}/modeles/{modeleId}/produits", name:"produits")]

    public function produits(int $modeleId): Response
    {
        $modele = $this->entityManager->getRepository(Modele::class)->find($modeleId);
        $produits = $this->entityManager->getRepository(Produit::class)->findBy(['modele' => $modele]);

        return $this->render('categories/produits.html.twig', [
            'modele' => $modele,
            'produits' => $produits,
        ]);
    }
}


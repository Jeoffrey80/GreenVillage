<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {
        $categories = $categorieRepository->findBy(['parent' => null]);
        $produits = $produitRepository->findAll();

        // Sélectionner 2 produits aléatoires
        $randomProducts = $this->selectRandomEntities($produits, 2);

        return $this->render('catalogue/index.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
            'randomProducts' => $randomProducts,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function categorie(Categorie $categorie): Response
    {
        // Convertir la PersistentCollection en tableau
        $sousCategories = $categorie->getSousCategories()->toArray();

        // Sélectionner 2 sous-catégories aléatoires
        $randomSubCategories = $this->selectRandomEntities($sousCategories, 2);

        return $this->render('catalogue/categorie.html.twig', [
            'categorie' => $categorie,
            'sousCategories' => $sousCategories,
            'randomSubCategories' => $randomSubCategories,
        ]);
    }

    #[Route('/produits/{id}', name: 'app_produits')]
    public function produits(Categorie $categorie): Response
    {
        // Convertir la PersistentCollection en tableau
        $produits = $categorie->getProduits()->toArray();

        // Sélectionner 2 produits aléatoires
        $randomProducts = $this->selectRandomEntities($produits, 2);

        return $this->render('catalogue/produits.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits,
            'randomProducts' => $randomProducts,
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit')]
    public function produit(Produit $produit): Response
    {
        return $this->render('catalogue/produit.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/get-products', name: 'get_products')]
    public function getProducts(): JsonResponse
    {
        $produits = $this->entityManager->getRepository(Produit::class)->findAll();

        $data = [];
        foreach ($produits as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'image' => $produit->getImage(),
                // Ajoutez d'autres champs si nécessaire
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/get-categories', name: 'get_categories')]
    public function getCategories(): JsonResponse
    {
        $categories = $this->entityManager->getRepository(Categorie::class)->findAll();

        $data = [];
        foreach ($categories as $categorie) {
            $data[] = [
                'id' => $categorie->getId(),
                'nom' => $categorie->getNom(),
                'image' => $categorie->getImage(),
                // Ajoutez d'autres champs si nécessaire
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(): Response
    {
        $categories = $this->entityManager->getRepository(Categorie::class)->findBy(['parent' => null]);

        return $this->render('catalogue/categorie.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/sous-categories/{id}', name: 'app_sous_categories')]
    public function sousCategories(Categorie $categorie): Response
    {
        // Convertir la PersistentCollection en tableau
        $sousCategories = $categorie->getSousCategories()->toArray();

        return $this->render('catalogue/sous_categories.html.twig', [
            'categorie' => $categorie,
            'sousCategories' => $sousCategories,
        ]);
    }

    // Méthode générique pour sélectionner des entités aléatoires
    private function selectRandomEntities(array $entities, int $count): array
    {
        shuffle($entities); // Mélanger les entités

        return array_slice($entities, 0, $count); // Sélectionner les premières $count entités
    }
}

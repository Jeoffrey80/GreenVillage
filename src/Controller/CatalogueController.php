<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $repo): Response
    {
        $categories = $repo->findBy([ "parent" => null ]);

         //dd($categories);

        return $this->render('catalogue/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function categorie(Categorie $categorie , int $id): Response
    {

            //dd($id);

        return $this->render('catalogue/categorie.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}
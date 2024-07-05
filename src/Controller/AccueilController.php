<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    #[Route('/images', name: 'get_images')]
    public function getImages(): JsonResponse
    {
        $imageDir = $this->getParameter('kernel.project_dir') . '../assets/img/modele';
        $images = array_diff(scandir($imageDir), ['.', '..']);
        $imagePaths = array_map(fn($image) => '../assets/img/modele/' . $image, $images);
        
        return new JsonResponse($imagePaths);
    }
}

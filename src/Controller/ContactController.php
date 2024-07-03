<?php
// src/Controller/ContactController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer d'autres données de l'utilisateur depuis la base de données
        // En utilisant le repository, par exemple : $utilisateurRepository->find($utilisateur->getId());

        // ... votre logique de traitement de la page de contact ici ...

        return $this->render('contact/index.html.twig', [
            'utilisateur' => $utilisateur,
            // ... d'autres données à passer à la vue ...
        ]);
    }
}
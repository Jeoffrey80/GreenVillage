<?php
// src/Controller/PaymentController.php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PaymentController extends AbstractController
{
    private $security;
    private $produitRepository;

    public function __construct(Security $security, ProduitRepository $produitRepository)
    {
        $this->security = $security;
        $this->produitRepository = $produitRepository;
    }

    #[Route("/payment", name:"app_payment")]
    public function index(SessionInterface $session): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->security->getUser();

        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Récupérer les produits du panier
        $panier_affichage = [];
        foreach ($panier as $id => $quantite) {
            $produit = $this->produitRepository->find($id);
            if ($produit) {
                $produit->quantite = $quantite;
                $panier_affichage[] = $produit;
            }
        }

        return $this->render('payment/index.html.twig', [
            'user' => $user,
            'panier' => $panier_affichage,
        ]);
    }

    #[Route("/payment/process", name: "app_payment_process", methods: ["POST"])]
    public function process(Request $request): Response
    {
        // Récupérer les données du formulaire
        $cardNumber = $request->request->get('cardNumber');
        $expiryDate = $request->request->get('expiryDate');
        $cvv = $request->request->get('cvv');


        // Exemple de redirection après traitement
        return $this->redirectToRoute('app_payment_success');
    }

    #[Route("/payment/success", name: "app_payment_success")]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }
}

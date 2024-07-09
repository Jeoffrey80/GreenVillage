<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $repo): Response
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Préparer un tableau pour afficher les produits du panier avec leur quantité
        $panier_affichage = [];

        // Parcourir le panier pour récupérer chaque produit avec sa quantité
        foreach ($panier as $id => $quantite) {
            $produit = $repo->find($id); // Récupérer le produit depuis le repository par son ID
            if ($produit) {
                $produit->quantite = $quantite; // Ajouter la quantité au produit pour l'affichage
                $panier_affichage[] = $produit; // Ajouter le produit au tableau d'affichage
            }
        }

        // Rendre la vue du panier en passant les produits à afficher
        return $this->render('panier/index.html.twig', [
            'panier' => $panier_affichage,
        ]);
    }

    #[Route('/add/{id}', name: 'app_add')]
    public function add(SessionInterface $session, Produit $produit): Response
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Vérifier si le produit est déjà dans le panier, l'ajouter ou augmenter sa quantité
        if (isset($panier[$produit->getId()])) {
            $panier[$produit->getId()]++;
        } else {
            $panier[$produit->getId()] = 1;
        }

        // Mettre à jour le panier dans la session
        $session->set("panier", $panier);

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/del/{id}', name: 'app_del')]
    public function del(SessionInterface $session, Produit $produit): Response
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);

        // Vérifier si le produit est dans le panier, diminuer sa quantité ou le supprimer
        if (isset($panier[$produit->getId()])) {
            $panier[$produit->getId()]--;
            if ($panier[$produit->getId()] <= 0) {
                unset($panier[$produit->getId()]);
            }
        }

        // Mettre à jour le panier dans la session
        $session->set("panier", $panier);

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/clear', name: 'app_clear')]
    public function clear(SessionInterface $session): Response
    {
        // Vider complètement le panier en session
        $session->set("panier", []);

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_panier');
    }

    // Cette méthode n'est pas une action de route mais un rendu interne pour le calcul de la quantité totale
    public function calcul_quantite(SessionInterface $session): Response
    {
        // Récupérer le panier depuis la session
        $panier = $session->get("panier", []);
        $quantite_totale = 0;

        // Calculer la quantité totale des produits dans le panier
        foreach ($panier as $id => $quantite) {
            $quantite_totale += $quantite;
        }

        // Rendre la vue avec la quantité totale calculée
        return $this->render('panier/quantite_totale.html.twig', [
            'quantite_totale' => $quantite_totale,
        ]);
    }
}

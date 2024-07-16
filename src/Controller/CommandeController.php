<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\BonLivraison;
use App\Entity\Facture;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'app_commander', methods: ['POST'])]
    public function commander(
        Request $request,
        ProduitRepository $produitRepository,
        ClientRepository $clientRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer le client connecté
        $client = $this->getUser(); // Assurez-vous que l'utilisateur est un client

        if (!$client) {
            return $this->redirectToRoute('app_login');
        }

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setClient($client);
        $commande->setDateDebutCommande(new \DateTime());
        $commande->setNomCommande('Commande ' . (new \DateTime())->format('Y-m-d H:i:s'));
        $commande->setStatut('En attente');
        $commande->setMontantTot('0'); // Montant initial

        // Récupérer les produits du panier (à partir de la session ou autre)
        $panier = $request->getSession()->get('panier', []);

        $montantTot = 0;
        foreach ($panier as $id => $quantite) {
            $produit = $produitRepository->find($id);
            if ($produit) {
                for ($i = 0; $i < $quantite; $i++) {
                    $commande->addProduit($produit);
                }
                $montantTot += $produit->getPrix() * $quantite;
            }
        }

        // Mettre à jour le montant total
        $commande->setMontantTot($montantTot);

        // Créer une facture
        $facture = new Facture();
        $facture->setCommande($commande);
        $facture->setDateEmission(new \DateTime());

        // Persister les données
        $entityManager->persist($commande);
        $entityManager->persist($facture);
        $entityManager->flush();

        // Rediriger vers la page de confirmation de commande
        return $this->redirectToRoute('app_commande_confirmation', ['id' => $commande->getId()]);
    }

    #[Route('/commande/confirmation/{id}', name: 'app_commande_confirmation')]
    public function confirmation(Commande $commande): Response
    {
        return $this->render('commande/confirmation.html.twig', [
            'commande' => $commande,
        ]);
    }
}

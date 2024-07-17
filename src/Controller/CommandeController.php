<?php

namespace App\Controller;

use App\Entity\Commande;
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

        // Récupérer le montant total TTC depuis le formulaire
        $montantTTC = $request->request->get('montant_ttc');

        // Valider et convertir le montant TTC en float
        try {
            $montantTTC = (float) $montantTTC;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Montant TTC invalide.');
        }

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setClient($client);
        $commande->setDateDebutCommande(new \DateTime());
        $commande->setNomCommande('Commande ' . (new \DateTime())->format('Y-m-d H:i:s'));
        $commande->setStatut('En attente');
        $commande->setMontantTot(0); // Montant initial
        $commande->setMontant(number_format($montantTTC, 2, '.', '')); // Formater le montant TTC avec 2 décimales

        // Calculer la date d'émission (7 jours après la date de début de commande)
        $dateEmission = (new \DateTime())->modify('+7 days');
        $commande->setDateEmission($dateEmission);

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

        // Mettre à jour le montant total HT (si nécessaire)
        // $commande->setMontantTot($montantTot); // Ceci pourrait ne pas être nécessaire si montant total est déjà géré dans l'entité

        // Persister les données
        $entityManager->persist($commande);
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

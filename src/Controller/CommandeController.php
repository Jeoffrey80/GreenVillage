<?php
// src/Controller/CommandeController.php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Client;
use App\Entity\CommandeProduit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Dompdf\Dompdf;
use Dompdf\Options;

class CommandeController extends AbstractController
{
    #[Route('/commander', name: 'app_commander', methods: ['POST'])]
    public function commander(
        Request $request,
        ProduitRepository $produitRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        // Récupérer le client connecté
        $client = $this->getUser();

        if (!$client instanceof Client) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les informations du client depuis l'entité Client
        $clientEntity = $entityManager->getRepository(Client::class)->find($client->getId());

        // Récupérer le montant total TTC depuis le formulaire
        $montantTTC = (float) $request->request->get('montant_ttc');

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setClient($clientEntity);
        $commande->setDateDebutCommande(new \DateTime());
        $commande->setNomCommande('Commande_' . $commande->getDateDebutCommande()->format('Y-m-d_H-i-s'));
        $commande->setStatut('En attente');
        $commande->setMontantTot(0); // Montant initial
        $commande->setMontant(number_format($montantTTC, 2, '.', '')); // Formater le montant TTC avec 2 décimales

        // Ajouter les adresses de livraison et de facturation
        $adresseLivraison = $request->request->get('adresseLivraison');
        $adresseFacturation = $request->request->get('adresseFacturation');
        $commande->setAdresseLivraison($adresseLivraison);
        $commande->setAdresseFacturation($adresseFacturation);

        // Calculer la date d'émission (7 jours après la date de début de commande)
        $dateEmission = (new \DateTime())->modify('+7 days');
        $commande->setDateEmission($dateEmission);

        // Récupérer les produits du panier (à partir de la session ou autre)
        $panier = $request->getSession()->get('panier', []);

        $montantTot = 0;
        foreach ($panier as $id => $quantite) {
            $produit = $produitRepository->find($id);
            if ($produit) {
                // Créer une entité CommandeProduit pour chaque produit dans la commande
                $commandeProduit = new CommandeProduit();
                $commandeProduit->setCommande($commande);
                $commandeProduit->setProduit($produit);
                $commandeProduit->setQuantite($quantite); // Définir la quantité ici
                $entityManager->persist($commandeProduit);

                $montantTot += $produit->getPrix() * $quantite;
            }
        }

        // Mettre à jour le montant total de la commande
        $commande->setMontantTot($montantTot);

        // Persister les données de la commande
        $entityManager->persist($commande);
        $entityManager->flush();

        // Données pour le PDF et l'email
        $data = [
            'client' => $clientEntity,
            'commande' => $commande,
            'produitsDetails' => $this->prepareProduitsDetails($panier, $produitRepository),
            'totalHT' => $montantTot,
            'montantTTC' => $montantTTC
        ];

        // Envoyer le bon de commande
        $this->generatePdf(
            'pdf/bon_commande.html.twig',
            'bon_commande',
            $data,
            $mailer,
            'Votre bon de commande',
            'Veuillez trouver ci-joint votre bon de commande.'
        );

        // Envoyer la facture
        $this->generatePdf(
            'pdf/facture.html.twig',
            'facture',
            $data,
            $mailer,
            'Votre facture',
            'Veuillez trouver ci-joint votre facture.'
        );

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

    private function generatePdf(string $template, string $filenamePrefix, array $data, MailerInterface $mailer, string $emailSubject, string $emailBody): void
    {
        $html = $this->renderView($template, $data);

        // Configuration de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Chargement du HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définition du format du papier et orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du PDF
        $dompdf->render();

        // Générer un nom de fichier unique avec le numéro de commande
        $filename = sprintf('%s_%s.pdf', $filenamePrefix, $data['commande']->getId());

        // Chemin complet du fichier sur le serveur
        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $filename;

        // Sauvegarder le PDF sur le serveur
        file_put_contents($filePath, $dompdf->output());

        // Construction du tableau HTML pour les produits
        $produitsHtml = '<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 5px;">Produit</th>
                            <th style="padding: 5px;">Quantité</th>
                            <th style="padding: 5px;">Prix unitaire</th>
                            <th style="padding: 5px;">Total HT</th>
                            <th style="padding: 5px;">Total TTC</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($data['produitsDetails'] as $detail) {
            $produitsHtml .= '<tr>
                        <td style="padding: 5px;">' . htmlspecialchars($detail['produit']->getNom()) . '</td>
                        <td style="padding: 5px;">' . $detail['quantite'] . '</td>
                        <td style="padding: 5px;">' . $detail['prix'] . ' €</td>
                        <td style="padding: 5px;">' . ($detail['quantite'] * $detail['prix']) . ' €</td>
                        <td style="padding: 5px;">' . $data['montantTTC'] . ' €</td>
                      </tr>';
        }

        $produitsHtml .= '</tbody></table>';

        // Construire le contenu HTML de l'email
        $emailHtmlContent = "
            <p>Bonjour,</p>
            <p>Veuillez trouver ci-joint votre <strong>{$emailSubject}</strong>.</p>
            <p>Voici les détails de votre commande :</p>
            <ul>
                <li><strong>Total HT:</strong> {$data['totalHT']} €</li>
                <li><strong>Montant TTC:</strong> {$data['montantTTC']} €</li>
            </ul>
            <p>Produits achetés :</p>
            {$produitsHtml}
            <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
            <p>Cordialement,</p>
            <p>Votre équipe de support</p>
        ";

        // Création de l'email
        $email = (new Email())
            ->from('contact@villagegreen.com')
            ->to('customer@example.com') // Remplacez par l'email du client
            ->subject($emailSubject)
            ->text(strip_tags($emailHtmlContent)) // Texte brut pour les clients de messagerie qui ne supportent pas HTML
            ->html($emailHtmlContent) // Contenu HTML de l'email
            ->attachFromPath($filePath); // Joindre le fichier PDF

        // Envoyer l'email
        $mailer->send($email);
    }

    // Fonction pour préparer les détails des produits à envoyer au PDF
    private function prepareProduitsDetails(array $panier, ProduitRepository $produitRepository): array
    {
        $produitsDetails = [];
        foreach ($panier as $id => $quantite) {
            $produit = $produitRepository->find($id);
            if ($produit) {
                $produitsDetails[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'prix' => $produit->getPrix(), // Vous pouvez ajuster selon la structure de votre produit
                ];
            }
        }
        return $produitsDetails;
    }
}

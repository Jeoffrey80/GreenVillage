<?php
// src/Controller/RoleController.php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Entity\Produit;
use App\Form\ProduitType;
//use App\Entity\Fournisseur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

#[Route('/Role')]
class RoleController extends AbstractController
{
    #[Route('/dashboard', name: 'Role_dashboard')]
    public function dashboard(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CHEF');

        $produits = $entityManager->getRepository(Produit::class)->findAll();

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );

                    $produit->setImage('../assets/img/Produit/' . $newFilename);

                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement du fichier.');
                    return $this->redirectToRoute('Role_dashboard');
                }
            }

            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été ajouté avec succès.');

            return $this->redirectToRoute('Role_dashboard');
        }

        return $this->render('Role/dashboard.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier_produit')]
    public function modifierProduit(Request $request, EntityManagerInterface $entityManager, Produit $produit): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CHEF');

        $imagePath = $produit->getImage();
    
        $form = $this->createForm(ProduitType::class, $produit, ['modifier_image' => true]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
    
            // Vérifier si une nouvelle image a été soumise
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
    
                    $produit->setImage('../assets/img/Produit/' . $newFilename);
    
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement du fichier.');
                    return $this->redirectToRoute('modifier_produit', ['id' => $produit->getId()]);
                }
            } else {
                // Garder l'image actuelle si aucune nouvelle image n'est téléchargée
                $produit->setImage($imagePath);
            }
    
            $entityManager->flush();
    
            $this->addFlash('success', 'Le produit a été modifié avec succès.');
    
            return $this->redirectToRoute('Role_dashboard');
        }
    
        return $this->render('Role/modifier_produit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer_produit')]
    public function supprimerProduit(EntityManagerInterface $entityManager, Produit $produit): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager->remove($produit);
        $entityManager->flush();

        $this->addFlash('success', 'Le plat a été supprimé avec succès.');

        return $this->redirectToRoute('Role_dashboard');
    }


    #[Route('/historique-commandes', name: 'app_historique_commandes')]
    public function historiqueCommandes(Request $request, CommandeRepository $commandeRepository): Response
    {
        // Filtrage et tri des commandes si nécessaire
        $dateCommande = $request->query->get('dateCommande');
        $client = $request->query->get('client');
        $sort = $request->query->get('sort', 'id');
        $direction = $request->query->get('direction', 'asc');

        // Créez le QueryBuilder
        $qb = $commandeRepository->createQueryBuilder('c')
            ->leftJoin('c.client', 'cl')
            ->addSelect('cl');

        if ($dateCommande) {
            $qb->andWhere('c.dateDebutCommande = :dateCommande')
               ->setParameter('dateCommande', new \DateTime($dateCommande));
        }

        if ($client) {
            $qb->andWhere('cl.nom LIKE :client')
               ->setParameter('client', '%' . $client . '%');
        }

        if ($sort === 'nom_client') {
            $qb->orderBy('cl.nom', $direction);
        } else {
            $qb->orderBy('c.' . $sort, $direction);
        }

        $commandes = $qb->getQuery()->getResult();

        return $this->render('Role/historique.html.twig', [
            'commandes' => $commandes,
            'utilisateur' => $this->getUser(),
        ]);
    }
}


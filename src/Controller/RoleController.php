<?php
// src/Controller/RoleController.php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
                        $this->getParameter('images_directory'), // Assurez-vous que 'images_directory' pointe vers votre répertoire d'images configuré
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

            $this->addFlash('success', 'Le plat a été ajouté avec succès.');

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
            }
    
            // Valider que l'image a bien été téléchargée
            if (!$produit->getImage()) {
                $this->addFlash('error', 'Veuillez télécharger une image.');
                return $this->redirectToRoute('modifier_produit', ['id' => $produit->getId()]);
            }
    
            $entityManager->flush();
    
            $this->addFlash('success', 'Le plat a été modifié avec succès.');
    
            return $this->redirectToRoute('Role_dashboard');
        }
    
        return $this->render('Role/modifier_produit.html.twig', [
            'form' => $form->createView(),
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
}


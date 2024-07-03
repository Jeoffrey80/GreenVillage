<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Form\ProduitType;

class RoleController extends AbstractController
{
    #[Route("/Role/dashboard", name: "Role_dashboard")]
    public function dashboard(Request $request, EntityManagerInterface $entityManager): Response
    {

        // Récupère tous les produits depuis la base de données
        $produits = $entityManager->getRepository(Produit::class)->findAll();

        // Crée une nouvelle instance de l'entité Produit et un formulaire associé
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérez le téléchargement du fichier ici
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Générez un nom unique pour le fichier
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    // Déplacez le fichier vers le répertoire approprié
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Utilisez le répertoire approprié ici
                        $newFilename
                    );

                    // Stockez le chemin complet dans la base de données
                    $produit->setImage('/home/jeoffrey/Bureau/GreenVillage/assets/img/produit/' . $newFilename);

                } catch (FileException $e) {
                    // Gérer l'exception, par exemple, afficher un message à l'utilisateur
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement du fichier.');
                    return $this->redirectToRoute('Role_dashboard');
                }
            }

            // Enregistrez les modifications dans la base de données
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Le plat a été ajouté avec succès.');

            return $this->redirectToRoute('Role_dashboard');
        }

        // Rend la vue avec le formulaire et la liste des plats
        return $this->render('Role/dashboard.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits,
        ]);
    }


    #[Route('/Role/modifier/{id}', name:'modifier_produit')]
    public function modifierproduit(Request $request, EntityManagerInterface $entityManager, Produit $produit): Response
    {
        // Crée le formulaire pour modifier le plat
        // En passant ['modifier_image' => false], on désactive le champ image pour la modification
        $form = $this->createForm(ProduitType::class, $produit, ['modifier_image' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ...

            // Mise à jour de l'image uniquement si le champ image est inclus dans le formulaire
            if ($form->has('image')) {
                $imageFile = $form->get('image')->getData();

                if ($imageFile) {
                    // Gestion du téléchargement de la nouvelle image
                }
            }


            // Enregistre les modifications dans la base de données
            $entityManager->flush();

            $this->addFlash('success', 'Le plat a été modifié avec succès.');

            return $this->redirectToRoute('Role_dashboard');
        }

        // Rend la vue avec le formulaire de modification
        return $this->render('Role/modifier_plat.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route("/Role/supprimer/{id}", name:"supprimer_plat")]
    public function supprimerProduit(EntityManagerInterface $entityManager, Produit $produit): Response
    {
        // Supprime le plat de la base de données
        $entityManager->remove($produit);
        $entityManager->flush();

        $this->addFlash('success', 'Le plat a été supprimé avec succès.');

        return $this->redirectToRoute('Role_dashboard');
    }
}
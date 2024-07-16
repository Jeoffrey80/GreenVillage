<?php
namespace App\Controller;

use App\Entity\Commercial;
use App\Form\CommercialType;
use App\Repository\CommercialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commercial')]
class CommercialController extends AbstractController
{
    #[Route('/', name: 'commercial_index')]
    public function index(CommercialRepository $commercialRepository): Response
    {
        $commerciaux = $commercialRepository->findAll();

        return $this->render('commercial/index.html.twig', [
            'commerciaux' => $commerciaux,
        ]);
    }

    #[Route('/ajouter', name: 'ajouter_commercial')]
    public function ajouter(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $commercial = new Commercial();
        $form = $this->createForm(CommercialType::class, $commercial);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Hacher le mot de passe avant de persister l'entité
            $commercial->hashPassword($hasher);

            $em->persist($commercial);
            $em->flush();

            return $this->redirectToRoute('commercial_index');
        }

        return $this->render('commercial/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier_commercial')]
    public function modifier(Commercial $commercial, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(CommercialType::class, $commercial);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le mot de passe a été changé, le hacher avant de sauvegarder
            if ($form->get('password')->getData()) {
                $commercial->hashPassword($hasher);
            }

            $em->flush();

            return $this->redirectToRoute('commercial_index');
        }

        return $this->render('commercial/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer_commercial')]
    public function supprimer(Commercial $commercial, EntityManagerInterface $em): Response
    {
        $em->remove($commercial);
        $em->flush();

        return $this->redirectToRoute('commercial_index');
    }
}

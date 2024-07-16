<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, Request $request, MailerInterface $mailer): Response
    {
        // Récupérer l'utilisateur connecté
        $token = $tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        // Vérifier si l'utilisateur est connecté et est un client
        if (!$user || !$authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Créer le formulaire de contact
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        // Traitement du formulaire lorsqu'il est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $email = (new Email())
                ->from($data['from'])
                ->to('contact@monsite.com')
                ->subject($data['subject'])
                ->html('<b>titre</b><hr>' . $data['message']);

            $mailer->send($email);

            $this->addFlash('success', 'Super, votre email est envoyé !');
            // Ajoutez des messages flash supplémentaires si nécessaire
            // $this->addFlash('error', 'ARGHHHH !!!!');
            // $this->addFlash('error', ' !!!!');

            return $this->redirectToRoute('app_contact');
        }

        // Afficher la template avec le formulaire et les données du client
        return $this->render('contact/contact.html.twig', [
            'client' => $user,
            'form' => $form->createView(), // Passer le formulaire à la template
        ]);
    }
}

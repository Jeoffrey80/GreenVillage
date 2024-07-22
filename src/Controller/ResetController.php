<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Form\ResetEmailType;
use App\Form\ChangePasswordType;
use Symfony\Component\Mime\Email;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetController extends AbstractController
{
    #[Route('/reset', name: 'app_reset')]
    public function index(
        Request $request, 
        MailerInterface $mailer, 
        EntityManagerInterface $manager, 
        ClientRepository $repo,
        UrlGeneratorInterface $urlGenerator
    ): Response
    {
        $form = $this->createForm(ResetEmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();
                $date = new DateTime();
                $date = $date->add(new DateInterval("PT10M"));

                $info = [
                    "email" => $data["from"], // Utilisez 'from' ici
                    "expireAt" => $date->format("Y-m-d H:i:s")
                ];
                $json = json_encode($info);
                $token = base64_encode($json);

                // Adaptez la recherche d'utilisateur pour utiliser 'adresse_mail'
                $user = $repo->findOneBy(["adresse_mail" => $data["from"]]);

                if ($user) {
                    $user->setToken($token);
                    $manager->flush();

                    // Générer une URL absolue pour le lien de réinitialisation
                    $resetUrl = $urlGenerator->generate('app_change', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                    $email = (new Email())
                        ->from('noreply@villagegreen.com')
                        ->to($data["from"]) // Utilisez 'from' ici
                        ->subject("Réinitialisation du mot de passe")
                        ->html("<!DOCTYPE html>
                                <html lang='fr'>
                                <head>
                                    <meta charset='UTF-8'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                    <title>Réinitialisation du mot de passe</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            background-color: #f4f4f4;
                                            color: #333;
                                            margin: 0;
                                            padding: 0;
                                        }
                                        .container {
                                            width: 100%;
                                            max-width: 600px;
                                            margin: 0 auto;
                                            background-color: #fff;
                                            padding: 20px;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                            border-radius: 8px;
                                        }
                                        .header {
                                            text-align: center;
                                            padding-bottom: 20px;
                                        }
                                        .header h1 {
                                            font-size: 24px;
                                            margin: 0;
                                            color: #007bff;
                                        }
                                        .content {
                                            padding: 20px 0;
                                        }
                                        .content p {
                                            margin: 0 0 10px;
                                        }
                                        .content a {
                                            display: inline-block;
                                            background-color: #007bff;
                                            color: #fff;
                                            text-decoration: none;
                                            padding: 10px 20px;
                                            border-radius: 5px;
                                        }
                                        .footer {
                                            text-align: center;
                                            padding-top: 20px;
                                            font-size: 12px;
                                            color: #777;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class='container'>
                                        <div class='header'>
                                            <h1>Réinitialisation du mot de passe</h1>
                                        </div>
                                        <div class='content'>
                                            <p>Bonjour,</p>
                                            <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous pour changer votre mot de passe :</p>
                                            <p><a href='" . $resetUrl . "'>Réinitialiser mon mot de passe</a></p>
                                            <p>Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet e-mail.</p>
                                        </div>
                                        <div class='footer'>
                                            <p>&copy; 2024 Village Green. Tous droits réservés.</p>
                                        </div>
                                    </div>
                                </body>
                                </html>");

                    $mailer->send($email);
                } else {
                    $this->addFlash('error', 'Aucun utilisateur trouvé avec cette adresse e-mail.');
                }

                $this->addFlash('success', 'Un email vous a été envoyé si l\'adresse est enregistrée !');
                return $this->redirectToRoute('app_login');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs.');
            }
        }

        return $this->render('reset/resetpassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/change/{token}', name: 'app_change')]
    public function change_password(
        Request $request, 
        EntityManagerInterface $manager, 
        ClientRepository $repo,
        UserPasswordHasherInterface $hasher,
        string $token
    ): Response
    {
        $user = $repo->findOneBy(["token" => $token]);
        $expire_at = json_decode(base64_decode($token), true)["expireAt"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $expire_at);
        $now = new DateTime();

        if ($user && $date > $now) {
            $form = $this->createForm(ChangePasswordType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                // Assurez-vous que le champ 'email' est dans le formulaire ChangePasswordType
                if ($data["password1"] == $data["password2"] && $user->getAdresseMail() == $data["email"]) {
                    $user->setPassword($hasher->hashPassword($user, $data["password1"]));
                    $user->setToken(null); // Optionnel : réinitialiser le token après changement de mot de passe
                    $manager->flush();

                    $this->addFlash('success', 'Votre mot de passe a été changé avec succès !');
                    return $this->redirectToRoute('app_login');
                }

                $this->addFlash('error', 'Les mots de passe ne correspondent pas ou l\'email est incorrect.');
            }
        } else {
            $this->addFlash('error', 'Token invalide ou expiré !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('reset/change.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

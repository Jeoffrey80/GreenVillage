<?php
// src/Controller/YourController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoliMentionController extends AbstractController
{
    #[Route("/politique", name:"app_politique")]
    public function politique(): Response
    {
        return $this->render('politique/index.html.twig');
    }

    #[Route("/mentions", name:"app_mentions")]
    public function mentions(): Response
    {
        return $this->render('mention/index.html.twig');
    }
}
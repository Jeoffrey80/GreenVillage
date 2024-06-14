<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cgu', name: 'cgu')]
class CguController extends AbstractController
{
    
         public function cgu(): Response
    {
        return $this->render('cgu/index.html.twig');
    }
}
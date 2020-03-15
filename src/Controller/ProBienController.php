<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProBienController extends AbstractController
{
    /**
     * @Route("/pro/bien", name="pro_bien")
     */
    public function index()
    {
        return $this->render('pro_bien/index.html.twig', [
            'controller_name' => 'ProBienController',
        ]);
    }
}

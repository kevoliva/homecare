<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProAlerteController extends AbstractController
{
    /**
     * @Route("/pro/alerte", name="pro_alerte")
     */
    public function index()
    {
        return $this->render('pro_alerte/index.html.twig', [
            'controller_name' => 'ProAlerteController',
        ]);
    }
}

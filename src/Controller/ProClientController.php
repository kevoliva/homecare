<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProClientController extends AbstractController
{
    /**
     * @Route("/pro/client", name="pro_client")
     */
    public function index()
    {
        return $this->render('pro_client/index.html.twig', [
            'controller_name' => 'ProClientController',
        ]);
    }
}

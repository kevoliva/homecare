<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pro")
 */
class ProClientController extends AbstractController
{
    /**
     * @Route("/", name="pro_client")
     */
    public function index()
    {
        return $this->render('professionnel/client/index.html.twig', [
            'controller_name' => 'ProClientController',
        ]);
    }
}

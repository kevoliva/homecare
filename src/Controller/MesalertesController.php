<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesalertesController extends AbstractController
{
    /**
     * @Route("/mesalertes", name="mesalertes")
     */
    public function index()
    {
        return $this->render('mesalertes/index.html.twig', [
            'controller_name' => 'MesalertesController',
        ]);
    }
}

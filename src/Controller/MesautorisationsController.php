<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesautorisationsController extends AbstractController
{
    /**
     * @Route("/mesautorisations", name="mesautorisations")
     */
    public function index()
    {
        return $this->render('mesautorisations/index.html.twig', [
            'controller_name' => 'MesautorisationsController',
        ]);
    }
}

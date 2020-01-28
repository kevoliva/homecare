<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesinterventionsController extends AbstractController
{
    /**
     * @Route("/mesinterventions", name="mesinterventions")
     */
    public function index()
    {
        return $this->render('mesinterventions/index.html.twig', [
            'controller_name' => 'MesinterventionsController',
        ]);
    }
}

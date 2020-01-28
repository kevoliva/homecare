<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesplansController extends AbstractController
{
    /**
     * @Route("/mesplans", name="mesplans")
     */
    public function index()
    {
        return $this->render('mesplans/index.html.twig', [
            'controller_name' => 'MesplansController',
        ]);
    }
}

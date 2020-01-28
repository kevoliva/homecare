<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MesfacturesController extends AbstractController
{
    /**
     * @Route("/mesfactures", name="mesfactures")
     */
    public function index()
    {
        return $this->render('mesfactures/index.html.twig', [
            'controller_name' => 'MesfacturesController',
        ]);
    }
}

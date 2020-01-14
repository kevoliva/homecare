<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomecareController extends AbstractController
{
    /**
     * @Route("/", name="homecare")
     */
    public function index()
    {
        return $this->render('homecare/index.html.twig', [
            'controller_name' => 'HomecareController',
        ]);
    }
}

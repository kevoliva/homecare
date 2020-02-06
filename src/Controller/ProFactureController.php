<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pro/facture")
 */
class ProFactureController extends AbstractController
{
    /**
     * @Route("/", name="pro_facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('/professionnel/facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="pro_facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('professionnel/facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }


}

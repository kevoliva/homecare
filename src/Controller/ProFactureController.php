<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use App\Repository\AutorisationRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/pro/{idBien}/facture")
*/
class ProFactureController extends AbstractController
{
  /**
  * @Route("/", name="pro_facture_index", methods={"GET"})
  */
  public function index(FactureRepository $factureRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('/professionnel/facture/index.html.twig', [
      'factures' => $factureRepository->findAll(),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/show/{id}", name="pro_facture_show", methods={"GET"})
  */
  public function show(Facture $facture, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('professionnel/facture/show.html.twig', [
      'facture' => $facture,
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }


}

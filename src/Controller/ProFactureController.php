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

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('/professionnel/facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBien($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/desalphabetique", name="pro_facture_index_desalpha", methods={"GET"})
  */
  public function ordreDesalphabetique(FactureRepository $factureRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('/professionnel/facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienOrdreDesalphabetique($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/recent", name="pro_facture_index_recent", methods={"GET"})
  */
  public function ordreRecent(FactureRepository $factureRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('/professionnel/facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienRecent($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/ancien", name="pro_facture_index_ancien", methods={"GET"})
  */
  public function OrdreAncien(FactureRepository $factureRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('/professionnel/facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienAncien($idBien),
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

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/facture/show.html.twig', [
      'facture' => $facture,
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }


}

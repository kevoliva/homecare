<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/my/{idBien}/facture")
*/
class FactureController extends AbstractController
{
  /**
  * @Route("/", name="facture_index", methods={"GET"})
  */
  public function index(FactureRepository $factureRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);
    // Envoyer les biens récupérés à la vue chargée de les afficher
    return $this->render('facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="facture_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $facture = new Facture();
    $form = $this->createForm(FactureType::class, $facture);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($facture);
      $entityManager->flush();

      return $this->redirectToRoute('facture_index', ['idBien' => $idBien]);
    }

    return $this->render('facture/new.html.twig', [
      'facture' => $facture,
      'bien'=> $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="facture_show", methods={"GET"})
  */
  public function show(Facture $facture, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('facture/show.html.twig', [
      'facture' => $facture,
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Facture $facture, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $form = $this->createForm(FactureType::class, $facture);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('facture_index', ['idBien' => $idBien]);
    }

    return $this->render('facture/edit.html.twig', [
      'facture' => $facture,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="facture_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Facture $facture, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($facture);
      $entityManager->flush();
    }

    return $this->redirectToRoute('facture_index', [
      'bien' => $bien,
      'idBien' => $idBien
    ]);
  }
}

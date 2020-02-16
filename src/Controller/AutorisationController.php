<?php

namespace App\Controller;

use App\Entity\Autorisation;
use App\Form\AutorisationType;
use App\Repository\AutorisationRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/my/{idBien}/autorisation")
*/
class AutorisationController extends AbstractController
{
  /**
  * @Route("/", name="autorisation_index", methods={"GET"})
  */
  public function index(AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('autorisation/index.html.twig', [
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="autorisation_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $autorisation = new Autorisation();
    $form = $this->createForm(AutorisationType::class, $autorisation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $autorisation->setBien($bien);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($autorisation);
      $entityManager->flush();

      return $this->redirectToRoute('autorisation_index', ['idBien' => $idBien]);
    }

    return $this->render('autorisation/new.html.twig', [
      'autorisation' => $autorisation,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="autorisation_show", methods={"GET"})
  */
  public function show(Autorisation $autorisation, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('autorisation/show.html.twig', [
      'autorisation' => $autorisation,
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="autorisation_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Autorisation $autorisation, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $form = $this->createForm(AutorisationType::class, $autorisation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('autorisation_index', ['idBien' => $idBien]);
    }

    return $this->render('autorisation/edit.html.twig', [
      'autorisation' => $autorisation,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="autorisation_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Autorisation $autorisation, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    if ($this->isCsrfTokenValid('delete'.$autorisation->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($autorisation);
      $entityManager->flush();
    }

    return $this->redirectToRoute('autorisation_index', [
      'bien' => $bien,
      'idBien' => $idBien
    ]);
  }
}

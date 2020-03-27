<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/my/{idBien}/intervention")
*/
class InterventionController extends AbstractController
{
  /**
  * @Route("/", name="intervention_index", methods={"GET"})
  */
  public function index(InterventionRepository $interventionRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('intervention/index.html.twig', [
      'interventions' => $interventionRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="intervention_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $intervention = new Intervention();
    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $intervention->setBien($bien);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($intervention);
      $entityManager->flush();

      return $this->redirectToRoute('intervention_index', ['idBien' => $idBien]);
    }

    return $this->render('intervention/new.html.twig', [
      'intervention' => $intervention,
      'bien'=> $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="intervention_show", methods={"GET"})
  */
  public function show(Intervention $intervention, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('intervention/show.html.twig', [
      'intervention' => $intervention,
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="intervention_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Intervention $intervention, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('intervention_index', ['idBien' => $idBien]);
    }

    return $this->render('intervention/edit.html.twig', [
      'intervention' => $intervention,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="intervention_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Intervention $intervention, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($intervention);
      $entityManager->flush();
    }

    return $this->redirectToRoute('intervention_index',
    ['bien' => $bien,
    'idBien' => $idBien
  ]);
}
}

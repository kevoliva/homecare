<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use App\Repository\AutorisationRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/pro/{idBien}/intervention")
*/
class ProInterventionController extends AbstractController
{
  /**
  * @Route("/", name="pro_intervention_index", methods={"GET"})
  */
  public function index(InterventionRepository $interventionRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/intervention/index.html.twig', [
      'interventions' => $interventionRepository->findByIdBien($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/desalphabetique", name="pro_intervention_index_desalpha", methods={"GET"})
  */
  public function ordreDesalphabetique(InterventionRepository $interventionRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/intervention/index.html.twig', [
      'interventions' => $interventionRepository->findByIdBienOrdreDesalphabetique($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/recent", name="pro_intervention_index_recent", methods={"GET"})
  */
  public function ordreRecent(InterventionRepository $interventionRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/intervention/index.html.twig', [
      'interventions' => $interventionRepository->findByIdBienRecent($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/ancien", name="pro_intervention_index_ancien", methods={"GET"})
  */
  public function ordreAncien(InterventionRepository $interventionRepository, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/intervention/index.html.twig', [
      'interventions' => $interventionRepository->findByIdBienAncien($idBien),
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="pro_intervention_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien, AutorisationRepository $autorisationRepository): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    $intervention = new Intervention();
    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $intervention->setBien($bien);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($intervention);
      $entityManager->flush();

      return $this->redirectToRoute('pro_intervention_index', ['idBien' => $idBien]);
    }

    return $this->render('professionnel/intervention/new.html.twig', [
      'intervention' => $intervention,
      'bien'=> $bien,
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/show/{id}", name="pro_intervention_show", methods={"GET"})
  */
  public function show(Intervention $intervention, AutorisationRepository $autorisationRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/intervention/show.html.twig', [
      'intervention' => $intervention,
      'autorisations' => $autorisationRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="pro_intervention_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Intervention $intervention): Response
  {
    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('intervention_index');
    }

    return $this->render('professionnel/intervention/edit.html.twig', [
      'intervention' => $intervention,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="pro_intervention_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Intervention $intervention): Response
  {
    if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($intervention);
      $entityManager->flush();
    }

    return $this->redirectToRoute('pro_intervention_index');
  }
}

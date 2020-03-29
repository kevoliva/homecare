<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Form\AlerteType;
use App\Repository\AlerteRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/my/{idBien}/alerte")
*/
class AlerteController extends AbstractController
{
  /**
  * @Route("/", name="alerte_index", methods={"GET"})
  */
  public function index(AlerteRepository $alerteRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/desalphabetique", name="alerte_index_desalpha", methods={"GET"})
  */
  public function ordreDesalphabetique(AlerteRepository $alerteRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienOrdreDesalphabetique($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/recent", name="alerte_index_recent", methods={"GET"})
  */
  public function ordreRecent(AlerteRepository $alerteRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienRecent($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/ancien", name="alerte_index_ancien", methods={"GET"})
  */
  public function ordreAncien(AlerteRepository $alerteRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienAncien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="alerte_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $alerte = new Alerte();
    $form = $this->createForm(AlerteType::class, $alerte);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $alerte->setBien($bien);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($alerte);
      $entityManager->flush();

      return $this->redirectToRoute('alerte_index', ['idBien' => $idBien]);
    }

    return $this->render('alerte/new.html.twig', [
      'alerte' => $alerte,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="alerte_show", methods={"GET"})
  */
  public function show(Alerte $alerte, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    return $this->render('alerte/show.html.twig', [
      'alerte' => $alerte,
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="alerte_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Alerte $alerte, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $form = $this->createForm(AlerteType::class, $alerte);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('alerte_index', ['idBien' => $idBien]);
    }

    return $this->render('alerte/edit.html.twig', [
      'alerte' => $alerte,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="alerte_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Alerte $alerte, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    if ($this->isCsrfTokenValid('delete'.$alerte->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($alerte);
      $entityManager->flush();
    }

    return $this->redirectToRoute('alerte_index', [
      'bien' => $bien,
      'idBien' => $idBien
    ]);
  }
}

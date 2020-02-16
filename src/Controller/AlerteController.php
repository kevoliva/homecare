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

    return $this->render('alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBien($idBien),
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

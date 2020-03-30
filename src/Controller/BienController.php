<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Form\BienType;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


/**
* @Route("/my")
*/
class BienController extends AbstractController
{
  /**
  * @Route("/", name="bien_index", methods={"GET"})
  */
  public function index(UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Propriétaire
    $repositoryProprietaire = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les propriétaires qui ont donné une autorisation enregistrés en BD
    $biens = $repositoryProprietaire->getBiensProprietaire($user);

    return $this->render('bien/index.html.twig', [
      'biens' => $biens
    ]);
  }

  /**
  * @Route("/new", name="bien_new", methods={"GET","POST"})
  */
  public function new(Request $request, UserInterface $user): Response
  {

    $bien = new Bien();
    $form = $this->createForm(BienType::class, $bien);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $bien->setVille(ucfirst(strtolower($bien->getVille())));
      $bien->setProprietaire($user);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($bien);
      $entityManager->flush();

      return $this->redirectToRoute('bien_index');
    }

    return $this->render('bien/new.html.twig', [
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }



  /**
  * @Route("/{idBien}/edit", name="bien_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, $idBien): Response
  {

    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $form = $this->createForm(BienType::class, $bien);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('bien_index');
    }

    return $this->render('bien/edit.html.twig', [
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="bien_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Bien $bien): Response
  {
    $this->denyAccessUnlessGranted('VIEW', $bien);
    if ($this->isCsrfTokenValid('delete'.$bien->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($bien);
      $entityManager->flush();
    }

    return $this->redirectToRoute('bien_index');
  }
}

<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Form\AlerteType;
use App\Repository\AlerteRepository;
use App\Repository\AutorisationRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/pro/{idBien}/alerte")
*/
class ProAlerteController extends AbstractController
{
  /**
  * @Route("/", name="pro_alerte_index")
  */
  public function index(AlerteRepository $alerteRepository, AutorisationRepository $autorisationRepository, $idBien, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBien($idBien),
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/desalphabetique", name="pro_alerte_index_desalpha")
  */
  public function ordreDesalphabetique(AlerteRepository $alerteRepository, AutorisationRepository $autorisationRepository, $idBien, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienOrdreDesalphabetique($idBien),
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/recent", name="pro_alerte_index_recent")
  */
  public function ordreRecent(AlerteRepository $alerteRepository, AutorisationRepository $autorisationRepository, $idBien, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienRecent($idBien),
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/ancien", name="pro_alerte_index_ancien")
  */
  public function ordreAncien(AlerteRepository $alerteRepository, AutorisationRepository $autorisationRepository, $idBien, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    return $this->render('professionnel/alerte/index.html.twig', [
      'alertes' => $alerteRepository->findByIdBienAncien($idBien),
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/show/{id}", name="pro_alerte_show", methods={"GET"})
  */
  public function show(Alerte $alerte, AutorisationRepository $autorisationRepository, $idBien, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);
    $this->denyAccessUnlessGranted('VIEW_DOC_PRO', $alerte);

    return $this->render('professionnel/alerte/show.html.twig', [
      'alerte' => $alerte,
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="pro_alerte_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien, AutorisationRepository $autorisationRepository, UserInterface $user): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW_PRO', $bien);

    $alerte = new Alerte();
    $form = $this->createForm(AlerteType::class, $alerte);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $alerte->setBien($bien);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($alerte);
      $entityManager->flush();

      return $this->redirectToRoute('pro_alerte_index', ['idBien' => $idBien]);
    }

    return $this->render('professionnel/alerte/new.html.twig', [
      'alerte' => $alerte,
      'bien'=> $bien,
      'autorisations' => $autorisationRepository->findByAutorisation($user, $bien),
      'form' => $form->createView(),
    ]);
  }
}

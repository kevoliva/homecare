<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    $this->denyAccessUnlessGranted('VIEW', $bien);

    // Envoyer les biens récupérés à la vue chargée de les afficher
    return $this->render('facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/desalphabetique", name="facture_index_desalpha", methods={"GET"})
  */
  public function ordreDesalphabetique(FactureRepository $factureRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    // Envoyer les biens récupérés à la vue chargée de les afficher
    return $this->render('facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienOrdreDesalphabetique($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/recent", name="facture_index_recent", methods={"GET"})
  */
  public function ordreRecent(FactureRepository $factureRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    // Envoyer les biens récupérés à la vue chargée de les afficher
    return $this->render('facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienRecent($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/ancien", name="facture_index_ancien", methods={"GET"})
  */
  public function ordreAncien(FactureRepository $factureRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);

    // Envoyer les biens récupérés à la vue chargée de les afficher
    return $this->render('facture/index.html.twig', [
      'factures' => $factureRepository->findByIdBienAncien($idBien),
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

    $this->denyAccessUnlessGranted('VIEW', $bien);

    $facture = new Facture();
    $form = $this->createForm(FactureType::class, $facture);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Récupérer données fichier PDF importé
      $fichierFacturePDF = $form->get('cheminFic')->getData();

      if ($fichierFacturePDF) {
        $originalFilename = pathinfo($fichierFacturePDF->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierFacturePDF->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
          $fichierFacturePDF->move(
            $this->getParameter('factures_directory'),
            $newFilename
          );
        } catch (FileException $e) {
          // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $facture->setCheminFic($newFilename);
      }

      $facture->setBien($bien);

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
  * @Route("/show/{id}", name="facture_show", methods={"GET"})
  */
  public function show(Facture $facture, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $this->denyAccessUnlessGranted('VIEW', $bien);
    $this->denyAccessUnlessGranted('VIEW_DOC', $facture);

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

    $this->denyAccessUnlessGranted('VIEW', $bien);
    $this->denyAccessUnlessGranted('VIEW_DOC', $facture);

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

    $this->denyAccessUnlessGranted('VIEW', $bien);
    $this->denyAccessUnlessGranted('VIEW_DOC', $facture);

    if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
      unlink('uploads/factures/'.$facture->getCheminFic());
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

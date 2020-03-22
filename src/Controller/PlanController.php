<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Form\PlanType;
use App\Repository\PlanRepository;
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
* @Route("/my/{idBien}/plan")
*/
class PlanController extends AbstractController
{
  /**
  * @Route("/", name="plan_index", methods={"GET"})
  */
  public function index(PlanRepository $planRepository, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('plan/index.html.twig', [
      'plans' => $planRepository->findByIdBien($idBien),
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/new", name="plan_new", methods={"GET","POST"})
  */
  public function new(Request $request, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $plan = new Plan();
    $form = $this->createForm(PlanType::class, $plan);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Récupérer données fichier PDF importé
      $fichierPlanPDF = $form->get('cheminFic')->getData();

      if ($fichierPlanPDF) {
        $originalFilename = pathinfo($fichierPlanPDF->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierPlanPDF->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
          $fichierPlanPDF->move(
            $this->getParameter('plans_directory'),
            $newFilename
          );
        } catch (FileException $e) {
          // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $plan->setCheminFic($newFilename);
      }

      $plan->setBien($bien);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($plan);
      $entityManager->flush();

      return $this->redirectToRoute('plan_index', ['idBien' => $idBien]);
    }

    return $this->render('plan/new.html.twig', [
      'plan' => $plan,
      'bien'=> $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="plan_show", methods={"GET"})
  */
  public function show(Plan $plan, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    return $this->render('plan/show.html.twig', [
      'plan' => $plan,
      'bien' => $bien
    ]);
  }

  /**
  * @Route("/{id}/edit", name="plan_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Plan $plan, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    $form = $this->createForm(PlanType::class, $plan);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('plan_index', ['idBien' => $idBien]);
    }

    return $this->render('plan/edit.html.twig', [
      'plan' => $plan,
      'bien' => $bien,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="plan_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Plan $plan, $idBien): Response
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);

    if ($this->isCsrfTokenValid('delete'.$plan->getId(), $request->request->get('_token'))) {
      // Supprimer fichier du dossier public/uploads
      unlink('uploads/plans/'.$plan->getCheminFic());

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($plan);
      $entityManager->flush();
    }

    return $this->redirectToRoute('plan_index',
    ['bien' => $bien,
    'idBien' => $idBien
  ]);
}
}

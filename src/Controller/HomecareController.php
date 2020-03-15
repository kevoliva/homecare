<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Bien;

class HomecareController extends AbstractController
{

  /**
  * @Route("/", name="homecare")
  */
  public function index()
  {
    return $this->render('accueil.html.twig', [
      'controller_name' => 'HomecareController',
    ]);
  }

  /**
  * @Route("/my/{idBien}", name="homecare_my")
  */
  public function indexMy($idBien)
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);
    // Envoyer les biens récupérés à la vue chargée de les afficher

    return $this->render('homecare/index.html.twig',
    ['bien' => $bien]);

    return $this->render('proprietaire_base.html.twig',
    ['bien' => $bien]);
  }


  /**
  * @Route("/pro/{idBien}", name="homecare_pro")
  */
  public function indexPro($idBien)
  {
    // Récupérer le repository de l'entité Bien
    $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les biens enregistrés en BD
    $bien = $repositoryBien->find($idBien);
    // Envoyer les biens récupérés à la vue chargée de les afficher

    return $this->render('professionnel/homecare/index.html.twig', [
      'bien' => $bien
    ]);

    return $this->render('professionnel_base.html.twig',
    ['bien' => $bien]);
  }
}

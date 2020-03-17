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
use Symfony\Component\Routing\Annotation\Route;

class ProAlerteController extends AbstractController
{
    /**
     * @Route("/pro/{idBien}/alerte", name="pro_alerte_index")
     */
    public function index(AlerteRepository $alerteRepository, AutorisationRepository $autorisationRepository, $idBien): Response
    {
      // Récupérer le repository de l'entité Bien
      $repositoryBien = $this->getDoctrine()->getRepository(Bien::class);
      // Récupérer les biens enregistrés en BD
      $bien = $repositoryBien->find($idBien);

      return $this->render('professionnel/alerte/index.html.twig', [
        'alertes' => $alerteRepository->findByIdBien($idBien),
        'autorisations' => $autorisationRepository->findByIdBien($idBien),
        'bien' => $bien
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
}

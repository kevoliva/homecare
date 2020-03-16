<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Form\PlanType;
use App\Repository\PlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/pro/{idBien}/plan")
*/
class ProPlanController extends AbstractController
{
  /**
  * @Route("/", name="pro_plan_index", methods={"GET"})
  */
  public function index(PlanRepository $planRepository): Response
  {
    return $this->render('professionnel/plan/index.html.twig', [
      'plans' => $planRepository->findAll(),
    ]);
  }



  /**
  * @Route("/{id}", name="pro_plan_show", methods={"GET"})
  */
  public function show(Plan $plan): Response
  {
    return $this->render('plan/show.html.twig', [
      'plan' => $plan,
    ]);
  }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bien;
use App\Form\BienType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @Route("/pro")
*/
class ProBienController extends AbstractController
{
  /**
  * @Route("/", name="pro_bien_index")
  */
  public function index(UserInterface $user)
  {
    // Récupérer le repository de l'entité Propriétaire
    $repositoryProprietaire = $this->getDoctrine()->getRepository(Bien::class);
    // Récupérer les propriétaires qui ont donné une autorisation enregistrés en BD
    $biens = $repositoryProprietaire->getBiensClients($user);

    return $this->render('professionnel/bien/index.html.twig', [
      'biens' => $biens
    ]);
  }
}

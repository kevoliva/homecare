<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserType;
use App\Entity\Professionnel;
use App\Entity\Proprietaire;
use App\Form\ProfessionnelType;
use App\Form\ProprietaireType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
  /**
  * @Route("/login", name="app_login")
  */
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    // if ($this->getUser()) {
    //     return $this->redirectToRoute('target_path');
    // }

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
  }

  /**
  * @Route("/logout", name="app_logout")
  */
  public function logout()
  {
    throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
  }

  /**
  * @Route("/inscription", name="app_choix_inscription")
  */
  public function choixInscription()
  {
    // Afficher la page présentant le choix d'inscription
    return $this->render('security/choixInscription.html.twig');
  }

  /**
  * @Route("/inscription/proprietaire", name="app_inscription_proprietaire")
  */
  public function inscriptionProprietaire(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
  {
    //Créer un utilisateur vide
    $proprietaire = new Proprietaire();

    // Création du formulaire permettant de saisir un utilisateur
    $formulaireProprietaire = $this->createForm(ProprietaireType::class, $proprietaire);

    /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
    dans cette requête contient des variables nom, prenom, etc. alors la méthode handleRequest()
    récupère les valeurs de ces variables et les affecte à l'objet $utilisateur*/
    $formulaireProprietaire->handleRequest($request);

    if ($formulaireProprietaire->isSubmitted() && $formulaireProprietaire->isValid())
    {
      $proprietaire->setRoles(['ROLE_PROPRIETAIRE']);

      // Avoir nom et prénom de cette forme là : Xxxxx Xxxxx
      $ancienPrenom = $proprietaire->getPrenom();
      $nouveauPrenom = $proprietaire->setPrenom(ucfirst(strtolower($ancienPrenom)));
      $ancienNom = $proprietaire->getNom();
      $nouveauNom = $proprietaire->setNom(ucfirst(strtolower($ancienNom)));

      $proprietaire->setEmail(strtolower($proprietaire->getEmail()));

      //Encoder le mot de passe de l'utilisateur
      $encodagePassword = $encoder->encodePassword($proprietaire, $proprietaire->getPassword());
      $proprietaire->setPassword($encodagePassword);

      // Enregistrer l'utilisateur en base de données
      $manager->persist($proprietaire);
      $manager->flush();

      // Rediriger l'utilisateur vers la page de login
      return $this->redirectToRoute('app_login');
    }

    // Afficher la page présentant le formulaire d'inscription
    return $this->render('security/inscriptionProprietaire.html.twig',['vueFormulaire' => $formulaireProprietaire->createView()]);
  }

  /**
  * @Route("/inscription/professionnel", name="app_inscription_professionnel")
  */
  public function inscriptionProfessionnel(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
  {
    //Créer un utilisateur vide
    $professionnel = new Professionnel();

    // Création du formulaire permettant de saisir un utilisateur
    $formulaireProfessionnel = $this->createForm(ProfessionnelType::class, $professionnel);

    /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
    dans cette requête contient des variables nom, prenom, etc. alors la méthode handleRequest()
    récupère les valeurs de ces variables et les affecte à l'objet $utilisateur*/
    $formulaireProfessionnel->handleRequest($request);

    if ($formulaireProfessionnel->isSubmitted() && $formulaireProfessionnel->isValid())
    {
      $professionnel->setRoles(['ROLE_PROFESSIONNEL']);

      $professionnel->setNomEntrep(strtoupper($professionnel->getNomEntrep()));

      $professionnel->setEmail(strtolower($professionnel->getEmail()));

      //Encoder le mot de passe de l'utilisateur
      $encodagePassword = $encoder->encodePassword($professionnel, $professionnel->getPassword());
      $professionnel->setPassword($encodagePassword);

      // Enregistrer l'utilisateur en base de données
      $manager->persist($professionnel);
      $manager->flush();

      // Rediriger l'utilisateur vers la page d'accueil
      return $this->redirectToRoute('app_login');
    }

    // Afficher la page présentant le formulaire d'inscription
    return $this->render('security/inscriptionProfessionnel.html.twig',['vueFormulaire' => $formulaireProfessionnel->createView()]);
  }
}

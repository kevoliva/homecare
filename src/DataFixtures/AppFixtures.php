<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Alerte;
use App\Entity\Autorisation;
use App\Entity\Bien;
use App\Entity\Facture;
use App\Entity\Intervention;
use App\Entity\Plan;
use App\Entity\Professionnel;
use App\Entity\Proprietaire;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {

    // Création d'un jeu de données faker
    $faker = \Faker\Factory::create('fr_FR');

    /***************************************
    *** CREATION D'UN PROPRIETAIRE ***
    ****************************************/

    $proprietaire = new Proprietaire();
    $proprietaire->setNom('Oliva');
    $proprietaire->setPrenom('Kévin');
    $proprietaire->setEmail('olivakevin64@gmail.com');
    $proprietaire->setRoles(['ROLE_PROPRIETAIRE']);
    $proprietaire->setPassword('$2y$10$JVFeF9RXZ.t6tWGIcY2YyugD0U1tJecz6/PHoKlHcwdbgSKGkxMLC');

    $professionnel = new Professionnel();
    $professionnel->setNomEntrep('Total');
    $professionnel->setEmail('kevinoliva.pro@gmail.com');
    $professionnel->setRoles(['ROLE_PROFESSIONNEL']);
    $professionnel->setPassword('$2y$10$JVFeF9RXZ.t6tWGIcY2YyugD0U1tJecz6/PHoKlHcwdbgSKGkxMLC');


    $manager->persist($proprietaire);
    $manager->persist($professionnel);

    /***************************************
    *** CREATION DU BIEN ASSOCIE ***
    ****************************************/

    $bien = new Bien();
    $bien->setAdresse($faker->streetAddress);
    $bien->setVille($faker->city);
    $bien->setCodePostal($faker->postcode);
    $bien->setDateConstruct($faker->dateTime($max = 'now', $timezone = null));
    $bien->setSurface($faker->numberBetween($min = 50, $max = 200));
    $bien->setProprietaire($proprietaire);

    $manager->persist($bien);

    /***************************************
    *** CREATION DU PLAN ASSOCIE AU BIEN ***
    ****************************************/

    $nbPlansAGenerer = $faker->numberBetween($min = 2, $max = 6);

    for ($numPlan = 0 ; $numPlan < $nbPlansAGenerer ; $numPlan++){
      $plan = new Plan();
      $plan->setLibelle($faker->realText($maxNbChars = 30, $indexSize = 2));
      $plan->setLaDate($faker->dateTime($max = 'now', $timezone = null));
      $plan->setCheminFic('/public/Proprietaire12/Bien5/Plans/neSaitPasEncore');

      // Relation Plan --> Bien
      $plan->setBien($bien);
      // Relation Bien --> Plan
      $bien->addPlan($plan);
      // Persister les objets modifiés
      $manager->persist($plan);
      $manager->persist($bien);
    }

    /***************************************
    *** CREATION DE LA FACTURE ASSOCIEE AU BIEN ***
    ****************************************/

    $nbFacturesAGenerer = $faker->numberBetween($min = 2, $max = 6);

    for ($numFacture = 0 ; $numFacture < $nbFacturesAGenerer ; $numFacture++){
      $facture = new Facture();
      $facture->setLibelle($faker->realText($maxNbChars = 30, $indexSize = 2));
      $facture->setLaDate($faker->dateTime($max = 'now', $timezone = null));
      $facture->setCheminFic('/public/Proprietaire12/Bien5/Factures/neSaitPasEncore');

      // Relation Facture --> Bien
      $facture->setBien($bien);
      // Relation Bien --> Facture
      $bien->addFacture($facture);
      // Persister les objets modifiés
      $manager->persist($facture);
      $manager->persist($bien);
    }

    /***************************************
    *** CREATION DE L'ALERTE ASSOCIEE AU BIEN ***
    ****************************************/

    $nbAlertesAGenerer = $faker->numberBetween($min = 1, $max = 4);

    for ($numAlerte = 0 ; $numAlerte < $nbAlertesAGenerer ; $numAlerte++){
      $alerte = new Alerte();
      $alerte->setLibelle($faker->realText($maxNbChars = 30, $indexSize = 2));
      $alerte->setLaDate($faker->dateTime($max = 'now', $timezone = null));
      $alerte->setDescription($faker->realText($maxNbChars = 250, $indexSize = 2));

      // Relation Facture --> Bien
      $alerte->setBien($bien);
      // Relation Bien --> Facture
      $bien->addAlerte($alerte);
      // Persister les objets modifiés
      $manager->persist($alerte);
      $manager->persist($bien);
    }

    /***************************************
    *** CREATION DE L'INTERVENTION ASSOCIEE AU BIEN ***
    ****************************************/

    $nbInterventionsAGenerer = $faker->numberBetween($min = 1, $max = 8);

    for ($numIntervention = 0 ; $numIntervention < $nbInterventionsAGenerer ; $numIntervention++){
      $intervention = new Intervention();
      $intervention->setLibelle($faker->realText($maxNbChars = 30, $indexSize = 2));
      $intervention->setTypeInterv($faker->realText($maxNbChars = 20, $indexSize = 2));
      $intervention->setObservation($faker->realText($maxNbChars = 150, $indexSize = 2));
      $intervention->setRemarque($faker->realText($maxNbChars = 150, $indexSize = 2));

      // Relation Facture --> Bien
      $intervention->setBien($bien);
      // Relation Bien --> Facture
      $bien->addIntervention($intervention);
      // Persister les objets modifiés
      $manager->persist($intervention);
      $manager->persist($bien);
    }


    // Tout envoyer en Base de données

    $manager->flush();
  }
}

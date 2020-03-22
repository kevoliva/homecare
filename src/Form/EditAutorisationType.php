<?php

namespace App\Form;

use App\Entity\Autorisation;
use App\Entity\Professionnel;
use App\Repository\ProfessionnelRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EditAutorisationType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('plan')

    ->add('facture')

    ->add('intervention')

    ->add('alerte')

    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Autorisation::class,
    ]);
  }
}

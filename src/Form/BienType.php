<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class BienType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('adresse')
    ->add('ville')
    ->add('codePostal')
    ->add('dateConstruct', DateType::class, ['widget' => 'single_text',
    'label' => 'Date de construction'])
    ->add('surface', TextType::class, ['label' => 'Surface (en m2)'])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Bien::class,
    ]);
  }
}

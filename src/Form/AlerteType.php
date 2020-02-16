<?php

namespace App\Form;

use App\Entity\Alerte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AlerteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('libelle', TextType::class, [
      'attr' => [
        'placeholder' => 'Chaudière à changer, four à vérifier...'
      ]
    ])

    ->add('laDate', DateType::class, ['widget' => 'single_text',
    'label' => 'Date'
  ])

  ->add('description', TextareaType::class, [
    'label' => 'Description de l\'alerte...',
    'attr' => [
      'rows' => 3,
    ]
  ])
  ;
}

public function configureOptions(OptionsResolver $resolver)
{
  $resolver->setDefaults([
    'data_class' => Alerte::class,
  ]);
}
}

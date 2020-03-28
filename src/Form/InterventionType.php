<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InterventionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('libelle', TextType::class, [
      'attr' => [
        'placeholder' => 'Réparation fuite salon, changement baignoire...'
      ],
      'label' => 'Libellé'
    ])

    ->add('typeInterv', ChoiceType::class, [
      'label' => 'Type d\'intervention',
      'choices' => [
        'Installation' => 'Installation',
        'Maintenance' => 'Maintenance',
        'Réparation' => 'Réparation',
        'Autre...' => 'Autre...',
      ]
    ])

    ->add('observation', TextareaType::class, [
      'attr' => [
        'placeholder' => 'Observations principales sur l\'intervention...',
        'rows' => 6,
      ],
      'label' => 'Observations'
    ])

    ->add('remarque', TextareaType::class, [
      'attr' => [
        'placeholder' => 'Remarques ou conseils à ajouter... (facultatif)',
        'rows' => 6,
      ],
      'label' => 'Remarques',
    ])

    ->add('laDate', DateType::class, ['widget' => 'single_text',
    'label' => 'Date de l\'intervention',
    'data' => new \DateTime("now")
  ])

  //->add('alerte')
  ;
}

public function configureOptions(OptionsResolver $resolver)
{
  $resolver->setDefaults([
    'data_class' => Intervention::class,
  ]);
}
}

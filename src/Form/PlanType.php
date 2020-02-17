<?php

namespace App\Form;

use App\Entity\Plan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class PlanType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('libelle', TextType::class, [
      'attr' => [
        'placeholder' => 'Général, cuisine, salle de bain...'
      ]
    ])

    ->add('laDate', DateType::class, ['widget' => 'single_text',
    'label' => 'Date du plan'])

    ->add('cheminFic', FileType::class, [
      'label' => 'Fichier à importer (PDF)',
      'mapped' => false,
      'required' => false,
      'attr' => [
        'placeholder' => 'Aucun fichier choisi',
        'accept' => '.pdf',
      ],
      'constraints' => [
        new File([
          'maxSize' => '4096k',
          'mimeTypes' => [
            'application/pdf',
            'application/x-pdf',
          ],
          'mimeTypesMessage' => 'Veuillez choisir un document PDF',
        ])
      ],
    ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Plan::class,
    ]);
  }

}

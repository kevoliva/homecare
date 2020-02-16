<?php

namespace App\Form;

use App\Entity\Plan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class PlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('laDate', DateType::class, ['widget' => 'single_text'])
            ->add('cheminFic', FileType::class, [
              'label' => 'Fichier à importer (PDF)',
              'mapped' => false,
              'required' => false,
              'constraints' => [
                new File([
                  'maxSize' => '1024k',
                  'mimeTypes' => [
                    'application/pdf',
                    'application/x-pdf',
                  ],
                  'mimeTypesMessage' => 'Veuillez choisir un document PDF',
                ])
              ],

            ])
            ->add('bien')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plan::class,
        ]);
    }

}

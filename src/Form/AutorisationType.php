<?php

namespace App\Form;

use App\Entity\Autorisation;
use App\Entity\Professionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutorisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plan')
            ->add('facture')
            ->add('intervention')
            ->add('alerte')
            ->add('professionnel')
            ->add('bien')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Autorisation::class,
        ]);
    }
}

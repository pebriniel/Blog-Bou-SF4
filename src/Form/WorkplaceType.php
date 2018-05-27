<?php

namespace App\Form;

use App\Entity\Workplace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkplaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('urlClean')
            ->add('typeContrat')
            ->add('visible')
            ->add('Address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workplace::class,
        ]);
    }
}

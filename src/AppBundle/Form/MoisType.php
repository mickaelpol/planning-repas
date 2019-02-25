<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'mois.select',
                'attr'  => [
                    'placeholder' => 'mois.title',
                ],
            ])
            ->add('days', IntegerType::class, [])
            ->add('monthNumber', IntegerType::class, [])
            ->add('year', IntegerType::class, [])
            ->add('plannings', CollectionType::class, [
                'label'         => false,
                'entry_type'    => PlanningType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Mois',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_mois';
    }


}

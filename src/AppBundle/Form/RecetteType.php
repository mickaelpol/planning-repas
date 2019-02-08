<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de votre Recette : ',
            ])
            ->add('compositions', CollectionType::class, [
                'attr'          => [
                    'class' => 'collection-item',
                ],
                'label'         => false,
                'entry_type'    => CompositionType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ])
//            ->add('etapes', CollectionType::class, [
//                'entry_type'    => EtapeType::class,
//                'entry_options' => [
//                    'label' => false,
//                ],
//                'allow_add'     => true,
//                'allow_delete'  => true,
//                'by_reference'  => false,
//            ])
            ->add('etapes', CollectionType::class,array(
                'label' => false,
                'entry_type' => EtapeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recette',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recette';
    }


}

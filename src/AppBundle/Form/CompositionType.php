<?php

namespace AppBundle\Form;

use AppBundle\Entity\Etape;
use AppBundle\Entity\Ingredient;
use mysql_xdevapi\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompositionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite', IntegerType::class, [
                'label' => 'ingredient.quantity',
            ])
            ->add('ingredient', EntityType::class, [
                'attr'         => [
                    'class' => 'collection-item',
                ],
                'class'        => Ingredient::class,
                'choice_label' => 'label',
                'label'        => 'ingredient.choice',
                'placeholder'  => 'ingredient.choices',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Composition',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_composition';
    }


}

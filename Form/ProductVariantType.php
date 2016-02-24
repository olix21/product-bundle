<?php

namespace Dywee\ProductBundle\Form;

use Dywee\ProductBundle\Entity\ProductOptionValue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductVariantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price',          NumberType::class)
            ->add('isPriceTTC',     CheckboxType::class, array('required' => false))
            ->add('recurrenceFreq', NumberType::class,   array('required' => false))
            ->add('recurrence',     NumberType::class,   array('required' => false))
            ->add('length',         NumberType::class,   array('required' => false))
            ->add('width',          NumberType::class,   array('required' => false))
            ->add('height',         NumberType::class,   array('required' => false))
            ->add('weight',         NumberType::class,   array('required' => false))
            ->add('stock',          NumberType::class,   array('required' => false))
            ->add('isPromotion',    CheckboxType::class, array('required' => false))
            ->add('promotionPrice', NumberType::class,   array('required' => false))
            ->add('state',          ChoiceType::class,   array('choices' => array(0 => 'Indisponible', 1 => 'Disponible', 2 => 'Bientot disponible', 3 => 'Seulement en magasin')))
            ->add('availableAt',    DateType::class,     array('required' => false))
            ->add('mainVariation',  CheckboxType::class, array('required' => false))
            ->add('productOptionValues', EntityType::class,
                array(
                    'class'         => 'DyweeProductBundle:ProductOptionValue',
                    'property'      => 'indentedName',
                    'multiple'      => true,
                    'expanded'      => true
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\ProductVariant'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dywee_productbundle_productvariant';
    }
}

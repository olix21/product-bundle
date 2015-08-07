<?php

namespace Dywee\ProductBundle\Form;

use Dywee\ProductBundle\Entity\ProductOptionValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductVariantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price',          'number')
            ->add('isPriceTTC',     'checkbox', array('required' => false))
            ->add('recurrenceFreq', 'number',   array('required' => false))
            ->add('recurrence',     'number',   array('required' => false))
            ->add('length',         'number',   array('required' => false))
            ->add('width',          'number',   array('required' => false))
            ->add('height',         'number',   array('required' => false))
            ->add('weight',         'number',   array('required' => false))
            ->add('stock',          'number',   array('required' => false))
            ->add('isPromotion',    'checkbox', array('required' => false))
            ->add('promotionPrice', 'number',   array('required' => false))
            ->add('state',          'choice',   array('choices' => array(0 => 'Indisponible', 1 => 'Disponible', 2 => 'Bientot disponible', 3 => 'Seulement en magasin')))
            ->add('availableAt',    'date',     array('required' => false))
            ->add('mainVariation',  'checkbox', array('required' => false))
            ->add('productOptionValues', 'entity',
                array(
                    'class'         => 'DyweeProductBundle:ProductOptionValue',
                    'property'      => 'indentedName',
                    'multiple'      => true,
                    'expanded'      => true
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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

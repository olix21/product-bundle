<?php

namespace Dywee\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeatureElementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('feature',        'entity',   array(
                'class'     => 'DyweeProductBundle:Feature',
                'property'  => 'name',
                'required'  => false
            ))
            ->add('isCustomValue',  'checkbox', array('required' => false))
            ->add('customValue',    'text',     array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\FeatureElement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dywee_productbundle_featureelement';
    }
}

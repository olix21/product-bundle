<?php

namespace Dywee\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('website')
            ->add('img')
            ->add('Sauvegarder', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\Brand'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dywee_productbundle_brand';
    }
}

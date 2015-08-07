<?php

namespace Dywee\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('enableMulti',    'checkbox', array('required' => false))
            ->add('parent', 'entity',   array(
                'class'     =>  'DyweeProductBundle:Category',
                'property'  =>  'name',
                'required'  =>  false
            ))
            ->add('position',   'number',   array('required' => false))
            ->add('isVisible',    'checkbox', array('required' => false))
            ->add('seoUrl')
            ->add('state',          'choice', array('choices' => array(0 => 'Désactivée', 1 => 'Activée')))
            ->add('sauvegarder', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dywee_productbundle_category';
    }
}

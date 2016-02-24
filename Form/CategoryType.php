<?php

namespace Dywee\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('enableMulti',    CheckboxType::class, array('required' => false))
            ->add('parent', 'entity',   array(
                'class'     =>  'DyweeProductBundle:Category',
                'property'  =>  'name',
                'required'  =>  false
            ))
            ->add('position',   NumberType::class,   array('required' => false))
            ->add('isVisible',    CheckboxType::class, array('required' => false))
            ->add('seoUrl')
            ->add('state',          ChoiceType::class, array('choices' => array(0 => 'Désactivée', 1 => 'Activée')))
            ->add('sauvegarder', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\Category'
        ));
    }
}

<?php

namespace Dywee\ProductBundle\Form;

use Dywee\ProductBundle\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;


class PromotionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array(
            Promotion::TYPE_AMOUNT => 'promotion.type.amount',
            Promotion::TYPE_PERCENT => 'promotion.type.percent',
            //Promotion::TYPE_PRODUCT => 'promotion.type.product'
        );

        $builder
            //->add('name',       TextType::class)
            ->add('type',       ChoiceType::class, array(
                'choices' => $choices
            ))
            ->add('value',      NumberType::class)
            ->add('beginAt',    DateType::class, array('required' => false, 'widget' => 'single_text'))
            ->add('endAt',      DateType::class, array('required' => false, 'widget' => 'single_text'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\Promotion'
        ));
    }
}

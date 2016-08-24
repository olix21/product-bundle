<?php

namespace Dywee\ProductBundle\Form;

use Dywee\ProductBundle\Entity\ProductSubscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductSubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array(
            ProductSubscription::RECURRENCE_UNIT_DAY => ProductSubscription::RECURRENCE_UNIT_DAY,
            ProductSubscription::RECURRENCE_UNIT_WEEK => ProductSubscription::RECURRENCE_UNIT_WEEK,
            ProductSubscription::RECURRENCE_UNIT_MONTH => ProductSubscription::RECURRENCE_UNIT_MONTH,
            ProductSubscription::RECURRENCE_UNIT_YEAR => ProductSubscription::RECURRENCE_UNIT_YEAR
        );

        $builder
            ->add('priceByShipment', CheckboxType::class, array('required' => false))
            ->add('recurrence')
            ->add('recurrenceUnit', ChoiceType::class, array('choices' => $choices))
            ->add('maxShipment')
            ->add('subscriptionElements',         CollectionType::class,      array(
                'entry_type' => PackElementType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
        ;
    }

    public function getParent()
    {
        return BaseProductType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\ProductSubscription'
        ));
    }
}

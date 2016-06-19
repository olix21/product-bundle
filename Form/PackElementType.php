<?php

namespace Dywee\ProductBundle\Form;

use Dywee\ProductBundle\Entity\ProductPack;
use Dywee\ProductBundle\Entity\ProductSubscription;
use Dywee\ProductBundle\Repository\BaseProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackElementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            //->add('discountRate')
            //->add('discountValue')
            //->add('unitPrice')
            //->add('totalPrice')
            ->add('product', EntityType::class, array(
                'class' => 'DyweeProductBundle:BaseProduct',
                'choice_label' => 'name'
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $entity = $event->getData();
            $form = $event->getForm();

            // Dans le cas où c'est la page d'accueil
            if ($entity instanceof ProductSubscription){
                $form->add('product', EntityType::class, array(
                    'class' => 'DyweeProductBundle:BaseProduct',
                    'choice_label' => 'name',
                    'query_builder' => function(BaseProductRepository $repo)
                    {
                        $repo->findAllWithoutSubscription();
                    }
                ));
            }
            elseif($entity instanceof ProductPack){
                $form->add('product', EntityType::class, array(
                    'class' => 'DyweeProductBundle:BaseProduct',
                    'choice_label' => 'name'
                ));
            }
        });

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\PackElement'
        ));
    }
}

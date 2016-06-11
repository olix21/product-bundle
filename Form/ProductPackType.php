<?php

namespace Dywee\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductPackType extends AbstractType
{
    //TODO: ajouter le packElement

    public function getParent()
    {
        return BaseProductType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\ProductPack'
        ));
    }
}

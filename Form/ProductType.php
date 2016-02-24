<?php

namespace Dywee\ProductBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dywee\CoreBundle\Form\Type\SeoType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images',             CollectionType::class,  array(
                    'type' => new ProductImageType(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
            ->add('name')
            ->add('brand',              EntityType::class,       array(
                'required' => false,
                'class' => 'DyweeProductBundle:Brand',
                'property' => 'name',))
            ->add('price',              MoneyType::class,       array('required' => false))
            ->add('isPriceTTC',         CheckboxType::class,    array('required' => false, 'label' => 'Prix TTC'))
            ->add('seo',                new SeoType(),          array(
                'data_class' => 'Dywee\BlogBundle\Entity\Article'
            ))
            ->add('shortDescription',   CKEditorType::class,    array('required' => false))
            ->add('mediumDescription',  CKEditorType::class,    array('required' => false))
            ->add('longDescription',    CKEditorType::class,    array('required' => false))
            ->add('sellType',           ChoiceType::class,      array('choices' => array(1 => 'Vente', 2 => 'Louable', 0 => 'Dematérialisé', 3 => 'Service')))
            ->add('length',             NumberType::class,      array('required' => false))
            ->add('width',              NumberType::class,      array('required' => false))
            ->add('height',             NumberType::class,      array('required' => false))
            ->add('weight',             NumberType::class,      array('required' => false))
            ->add('stock',              NumberType::class,      array('required' => false))
            ->add('isPromotion',        CheckboxType::class,    array('required' => false, 'label' => 'En promotion'))
            ->add('promotionPrice',     MoneyType::class,       array('required' => false))
            ->add('productType',        ChoiceType::class,      array('choices' => array(1 => 'Produit', 2 => 'Pack de produit', 3 => 'Abonnement', 4 => 'Service')))
            ->add('state',              ChoiceType::class,      array('choices' => array(0 => 'Indisponible', 1 => 'Disponible', 2 => 'Bientot disponible', 3 => 'Seulement en magasin', 4 => 'Seulement en pack ou abonnement', 5 => 'Rupture de stock')))
            ->add('categories',         EntityType::class,      array(
                'required' => false,
                'class' => 'DyweeProductBundle:Category',
                'property' => 'indentedName',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'query_builder' => function($er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.root', 'ASC')
                        ->addOrderBy('c.lft', 'ASC');
                }
            ))
            ->add('features',           CollectionType::class,  array(
                'type'          => FeatureElementType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false
            ))
            ->add('packElements',       CollectionType::class,  array(
                'type'          => PackElementType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false
            ))
            ->add('productVariants',    CollectionType::class,  array(
                'type'          => ProductVariantType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false
            ))
            ->add('sauvegarder',    SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\Product'
        ));
    }
}

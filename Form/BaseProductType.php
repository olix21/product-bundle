<?php

namespace Dywee\ProductBundle\Form;

use Dywee\CoreBundle\Form\Type\SeoType;
use Dywee\ProductBundle\Entity\Product;
use Dywee\TagBundle\Form\Type\TagType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stateChoices = [];

        foreach (Product::getConstantList() as $constant) {
            if (strpos($constant, 'state.')) {
                $stateChoices[$constant] = strtolower($constant);
            }
        }

        $builder
            ->add('name')
            ->add('brand', EntityType::class, [
                'required'     => false,
                'class'        => 'DyweeProductBundle:Brand',
                'choice_label' => 'name'
            ])
            ->add('price', MoneyType::class, ['required' => false])
            ->add('isPriceTTC', CheckboxType::class, ['required' => false, 'label' => 'Prix TTC'])
            ->add('seo', SeoType::class, [
                'data_class' => 'Dywee\ProductBundle\Entity\BaseProduct'
            ])
            ->add('shortDescription', CKEditorType::class, ['required' => false])
            ->add('mediumDescription', CKEditorType::class, ['required' => false])
            ->add('longDescription', CKEditorType::class, ['required' => false])
            ->add('length', NumberType::class, ['required' => false])
            ->add('width', NumberType::class, ['required' => false])
            ->add('height', NumberType::class, ['required' => false])
            ->add('weight', NumberType::class, ['required' => false])
            ->add('stock', NumberType::class, ['required' => false])
            ->add('state', ChoiceType::class, ['choices' => $stateChoices])
            ->add('categories', EntityType::class, [
                'required'      => false,
                'class'         => 'DyweeProductBundle:Category',
                'choice_label'  => 'indentedName',
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.root', 'ASC')
                        ->addOrderBy('c.lft', 'ASC');
                }
            ])
            ->add('features', CollectionType::class, [
                'entry_type'   => FeatureElementType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('pictures', CollectionType::class, [
                'entry_type'   => ProductPictureType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('promotions', CollectionType::class, [
                'entry_type'   => PromotionType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            /*->add('tags', TagType::class, array(
                'type' => 'product'
            ))*/
            ->add('relatedProducts', EntityType::class, [
                'required'     => false,
                'class'        => 'DyweeProductBundle:Product',
                'choice_label' => 'name',
                'multiple'     => true,
                'expanded'     => true
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Dywee\ProductBundle\Entity\BaseProduct'
        ]);
    }
}

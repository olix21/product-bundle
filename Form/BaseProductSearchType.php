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

class BaseProductSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stateChoices = array();

        foreach (Product::getConstantList() as $constant) {
            if (strpos($constant, 'state.')) {
                $stateChoices[$constant] = strtolower($constant);
            }
        }

        $builder
            ->add('name')
            ->add('brand', EntityType::class, array(
                'required' => false,
                'class' => 'DyweeProductBundle:Brand',
                'choice_label' => 'name'
            ))
            ->add('stock', NumberType::class, array('required' => false))
            ->add('state', ChoiceType::class, array('choices' => $stateChoices))
            ->add('categories', EntityType::class, array(
                'required' => false,
                'class' => 'DyweeProductBundle:Category',
                'choice_label' => 'indentedName',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.root', 'ASC')
                        ->addOrderBy('c.lft', 'ASC');
                }
            ))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\ProductBundle\Entity\BaseProduct'
        ));
    }
}

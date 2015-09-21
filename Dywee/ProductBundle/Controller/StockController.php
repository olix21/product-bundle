<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\NotificationBundle\Entity\Alert;
use Dywee\NotificationBundle\Entity\Notification;
use Dywee\ProductBundle\Entity\ProductOption;
use Dywee\ProductBundle\Form\ProductOptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller
{
    public function tableAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pmr = $em->getRepository('DyweeCoreBundle:ParametersManager');

        $stockEnabled = $pmr->findOneByName('stockManagementEnabled');
        $stockWarning = $pmr->findOneByName('stockWarningTreshold');
        $stockAlert = $pmr->findOneByName('stockAlertTreshold');

        $data['stockEnabled'] = $stockEnabled->getValue() == 1;
        $data['stockWarning'] = $stockWarning->getValue();
        $data['stockAlert'] = $stockAlert->getValue();

        $stockPreviousState = $data['stockEnabled'];

        $form = $this->createFormBuilder($data)
            ->add('stockEnabled', 'checkbox', array('required' => false))
            ->add('stockWarning', 'number')
            ->add('stockAlert', 'number')
            ->add('eraseConfig', 'checkbox', array('required' => false, 'label' => 'Mettre à jour les produits existants (écrasement des paramètres existants)'))
            ->add('Valider', 'submit')
            ->getForm();

        if($form->handleRequest($request)->isValid())
        {
            $formData = $form->getData();

            $stockEnabled->setValue($formData['stockEnabled']?1:0);
            $stockWarning->setValue($formData['stockWarning']);
            $stockAlert->setValue($formData['stockAlert']);

            $em->persist($stockEnabled);
            $em->persist($stockWarning);
            $em->persist($stockAlert);

            //Si on décide d'écraser les paramètres déjà existant
            if($formData['eraseConfig'])
            {
                $pr = $em->getRepository('DyweeProductBundle:Product');
                $ps = $pr->findAll();
                foreach($ps as $product)
                {
                    $product->setStockAlertTreshold($stockAlert->getValue());
                    $product->setStockWarningTreshold($stockWarning->getValue());
                    $em->persist($product);
                }
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Paramètres de stock correctement mis à jour');
        }

        return $this->render('DyweeProductBundle:Stock:dashboard.html.twig', array('form' => $form->createView()));
    }
}

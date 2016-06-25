<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\Feature;
use Dywee\ProductBundle\Form\FeatureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class FeatureController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="product_feature_table", path="admin/product/feature")
     */
    public function tableAction()
    {
        return $this->render('DyweeProductBundle:Feature:table.html.twig', array(
            'featureList' => $this->getDoctrine()->getRepository('DyweeProductBundle:Feature')->findAll()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="product_feature_add", path="admin/product/feature/add")
     */
    public function addAction(Request $request)
    {
        $feature = new Feature();

        $form = $this->get('form.factory')->create(FeatureType::class, $feature);

        if($form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Caractéristique bien ajoutée');
            return $this->redirect($this->generateUrl('product_feature_table'));
        }
        return $this->render('DyweeProductBundle:Feature:add.html.twig', array('form' => $form->createView()));
    }


    /**
     * @param Feature $feature
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="product_feature_update", path="admin/product/feature/{id}/update")
     */
    public function updateAction(Feature $feature, Request $request)
    {
        $form = $this->get('form.factory')->create(FeatureType::class, $feature);

        if($form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Caractéristique bien modifiée');
            return $this->redirect($this->generateUrl('product_feature_table'));
        }
        return $this->render('DyweeProductBundle:Feature:edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Feature $feature
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route(name="product_feature_delete", path="admin/product/feature/{id}/delete")
     */
    public function deleteAction(Feature $feature)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($feature);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Caractéristique bien supprimée');

        return $this->redirect($this->generateUrl('product_feature_table'));
    }
}

<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\Feature;
use Dywee\ProductBundle\Form\FeatureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FeatureController extends Controller
{
    /**
     * @Route(name="product_feature_table", path="admin/product/feature")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tableAction()
    {
        return $this->render('DyweeProductBundle:Feature:table.html.twig', [
            'featureList' => $this->getDoctrine()->getRepository('DyweeProductBundle:Feature')->findAll(),
        ]);
    }

    /**
     * @Route(name="product_feature_add", path="admin/product/feature/add")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $feature = new Feature();

        $form = $this->get('form.factory')->create(FeatureType::class, $feature);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Caractéristique bien ajoutée');

            return $this->redirect($this->generateUrl('product_feature_table'));
        }

        return $this->render('DyweeProductBundle:Feature:add.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route(name="product_feature_update", path="admin/product/feature/{id}/update")
     *
     * @param Feature $feature
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Feature $feature, Request $request)
    {
        $form = $this->get('form.factory')->create(FeatureType::class, $feature);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Caractéristique bien modifiée');

            return $this->redirect($this->generateUrl('product_feature_table'));
        }

        return $this->render('DyweeProductBundle:Feature:edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(name="product_feature_delete", path="admin/product/feature/{id}/delete")
     *
     * @param Feature $feature
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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

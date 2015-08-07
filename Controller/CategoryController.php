<?php

namespace Dywee\ProductBundle\Controller;

use Dywee\ProductBundle\Entity\Category;
use Dywee\ProductBundle\Entity\Product;
use Dywee\ProductBundle\Form\CategoryType;
use Dywee\ProductBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function tableAction($page = 1, $id = false)
    {
        $em = $this->getDoctrine()->getManager();

        $cr = $this->getDoctrine()->getManager()->getRepository('DyweeProductBundle:Category');

        if(is_numeric($id))
        {
            $c = $cr->findOneById($id);
            if($c == null)
                throw $this->createNotFoundException('Categorie non trouvée');

            $categoryList = $cr->findOneById($c)->getChildren();
        }
        else $categoryList = $cr->findByLvl(0);

        return $this->render('DyweeProductBundle:Category:table.html.twig', array('categoryList' => $categoryList));
    }

    public function viewAction($data)
    {
        $em = $this->getDoctrine()->getManager();

        $cr = $em->getRepository('DyweeProductBundle:Category');
        $param = is_numeric($data)?array('id' => $data):array('seoUrl' => $data);
        $category = $cr->findOneBy($param);

        $pr = $em->getRepository('DyweeProductBundle:Product');
        $productList = $pr->findByCategory($category);

        if($category != null)
        {
            $data = array('productList' => $productList, 'category' => $category);
            return $this->render('DyweeProductBundle:Eshop:browseByCategory.html.twig', $data);
        }
        throw $this->createNotFoundException('Catégorie introuvable');
    }

    public function filterAjaxAction()
    {
        //productByPage a rendre paramétrable dans config.yml
        $productByPage = 9;

        $request = $this->container->get('request');

        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $pr = $em->getRepository('DyweeProductBundle:Product');

            $categoriesId = array();

            $categories = $this->get('request')->get('categories');
            $page = $this->get('request')->get('page');

            $limit = $productByPage * $page;
            $offset = ($page-1)*$productByPage;

            //Si aucune sélection on affiche tout, sinon on normalise les id et on findByCategoriesid
            if(empty($categories))
                $pl = $pr->findByCategoriesId(array(), 1, $limit, $offset);
            else {
                foreach ($categories as $id => $name)
                    $categoriesId[] = ltrim($id, 'id_');

                $pl = $pr->findByCategoriesId($categoriesId, 1, $limit, $offset);
            }

            //On retient la sélection en session + le numéro de page
            $this->get('session')->set('eshop.activeCategories', $categories);
            $this->get('session')->set('eshop.currentPage', $page);

            $html = '<div class="row">';

            //Mise en page
            foreach($pl as $product)
            {
                $html .= '<div class="col-lg-4 col-sm-6 col-xs-12">';
                $html .= $this->renderView('DyweeProductBundle:Eshop:preview-product.html.twig', array('product' => $product));
                $html .= '</div>';

            }
            $html .= '</div>';

            $response = new Response();
            $response->setContent(
                json_encode(
                    array(
                        'type' => 'success',
                        'html' => $html,
                        'page' => (int) $page,
                        'nbrePages' => ceil($pr->countByCategoriesId($categoriesId)/$productByPage)
                    )
                )
            );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        throw $this->createNotFoundException('Erreur dans la requête');
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setState(1);

        $form = $this->get('form.factory')->create(new CategoryType, $category);

        if($form->handleRequest($request)->isValid()){

            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Catégorie bien ajoutée');
            return $this->redirect($this->generateUrl('dywee_product_category_table'));
        }
        return $this->render('DyweeProductBundle:Category:add.html.twig', array('form' => $form->createView()));
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cr = $em->getRepository('DyweeProductBundle:Category');

        $category = $cr->findOneById($id);

        $form = $this->get('form.factory')->create(new CategoryType, $category);

        if($form->handleRequest($request)->isValid()){

            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Catégorie bien modifiée');
            return $this->redirect($this->generateUrl('dywee_product_category_table'));
        }
        return $this->render('DyweeProductBundle:Category:edit.html.twig', array('form' => $form->createView()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cr = $em->getRepository('DyweeProductBundle:Category');

        $category = $cr->findOneById($id);

        if($category !== null)
        {
            $em->remove($category);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Catégorie bien supprimée');

            return $this->redirect($this->generateUrl('dywee_product_category_table'));
        }
        throw $this->createNotFoundException('Cette catégorie n\'existe plus');
    }
}

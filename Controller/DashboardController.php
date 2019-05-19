<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 8/09/17
 * Time: 17:52
 */

namespace Dywee\ProductBundle\Controller;


use Dywee\ProductBundle\Entity\BaseProduct;

/**
 * Class DashboardController
 *
 * @package Dywee\ProductBundle\Controller
 */
class DashboardController
{
    /**
     * @return mixed
     */
    public function tableAction()
    {
        $or = $this->getDoctrine()->getManager()->getRepository(BaseProduct::class);

        $query = $or->FindAllForPagination($state);

        return $this->render('DyweeProductBundle:Dashboard:miniTable.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @return mixed
     */
    public function cardAction()
    {
        $count = $this->getDoctrine()->getManager()->getRepository(BaseProduct::class)->countActive();

        return $this->render('DyweeProductBundle:Dashboard:card.html.twig', ['count' => $count]);
    }
}

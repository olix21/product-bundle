<?php

namespace Dywee\ProductBundle\Controller\Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseProductRestController extends Controller
{
    protected $childrenClassNameWithNamespace;
    protected $childrenClassName;
    protected $childrenClassNameUnderscored;


    public function __construct()
    {
        $this->getObjectNames();
    }

    public function getObjectNames($object = null)
    {
        $this->childrenClassNameWithNamespace = str_replace('\\\\', '\Entity\\', str_replace(array('Controller', 'Rest'), '', get_class($object ?? $this)));
        $exploded = explode('\\', $this->childrenClassNameWithNamespace);
        $this->childrenClassName = $exploded[count($exploded)-1];

        //To underscore
        $split = str_split($this->childrenClassName);
        $return = '';
        foreach($split as $letter){
            if(ctype_upper($letter) && strlen($return) > 1){
                $return .= '_';
            }
            $return .= $letter;
        }
        $this->childrenClassNameUnderscored = strtolower($return);
    }


    public function tableAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $repository = $this->getDoctrine()->getRepository('DyweeProductBundle:'.$this->childrenClassName);

            $products = $repository->findAll();

            $return = $this->get('serializer')->serialize($products, 'json', array('groups' => array('list')));

            return new Response($return);
        }
    }
}

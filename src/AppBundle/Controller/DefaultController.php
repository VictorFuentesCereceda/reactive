<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMINISTRATOR')){
            return $this->forward("AppBundle:Form:forms");
        }else{
            return $this->forward("AppBundle:Answer:listFormAnswers");
        }
    }
}

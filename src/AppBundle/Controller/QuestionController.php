<?php

namespace AppBundle\Controller;



use AppBundle\Form\FormType;
use AppBundle\Form\QuestionType;
use Assetic\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{

    /**
     * @Route("/questions/new", name="questions_new")
     */
    public function createFormAction()
    {

        $form = $this->createForm(QuestionType::class);

        $html= $this->renderView('AppBundle:Question:form.html.twig', array('form'=>$form->createView()));

        $form = $this->createForm(QuestionType::class);

        $html2= $this->renderView('AppBundle:Question:form.html.twig',
            array('form'=>$form->createView()));

        return new Response($html.$html2);

    }


}

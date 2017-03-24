<?php

namespace AppBundle\Controller;

use AppBundle\Form\FormType;
use AppBundle\Form\QuestionType;
use Assetic\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    /**
     * @Route("/forms/answer", name="list_forms_answer")
     */
    public function saveFormAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $forms=$em->getRepository('AppBundle:Answer')->findForUser($this->getUser()->getId());
        return $this->render('AppBundle:Form:index.html.twig',
            array('forms'=>$forms,'title'=>'Formularios para responder','admin'=>false));
    }

    /**
     * @Route("/answer", name="answer_form")
     */
    public function answerFormAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formId=$request->get("formId");

        $form=$em->getRepository('AppBundle:Form')->find($formId);
        return $this->render('AppBundle:Form:answer.html.twig',
            array('form'=>$form));
    }

}

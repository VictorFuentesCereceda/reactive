<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnswerController extends Controller
{
    /**
     * @Route("/forms/answer", name="list_forms_answer")
     * @Security("has_role('ROLE_USER')")
     */
    public function listFormAnswersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $forms=$em->getRepository('AppBundle:Answer')->findForUser($this->getUser()->getId());
        return $this->render('AppBundle:Form:index.html.twig',
            array('forms'=>$forms,'title'=>'Formularios para responder','mode'=>'user'));
    }

    /**
     * @Route("/answer", name="answer_form")
     * @Security("has_role('ROLE_USER')")
     */
    public function answerFormAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formId=$request->get("formId");
        $form=$em->getRepository('AppBundle:Form')->find($formId);
        return $this->render('AppBundle:Form:answer.html.twig',
            array('form'=>$form));
    }

    /**
     * @Route("/answer/save", name="save_answer")
     * @Security("has_role('ROLE_USER')")
     */
    public function saveAnswerFormAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formId=$request->get("form_id");
        $answers=$request->get("ques");
        if($formId && count($answers)>0) {
            $form = $em->getRepository('AppBundle:Form')->find($formId);
            if($form) {
                foreach ($answers as $clave => $answer) {
                    $question = $em->getRepository('AppBundle:Question')->find($clave);
                    $newAnswer = new Answer();
                    $newAnswer->setForm($form);
                    $newAnswer->setQuestion($question);
                    $newAnswer->setAnswer($answer);
                    $newAnswer->setUser($this->getUser());
                    $em->persist($newAnswer);
                }
                $em->flush();

                return new Response(1);
            }else{
                return new Response(0);
            }
        }else{
            return new Response(0);
        }
    }

    /**
     * @Route("/results", name="results")
     * @Security("has_role('ROLE_ADMINISTRATOR')")
     */
    public function resultsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $forms=$em->getRepository('AppBundle:Form')->findWithAnswers();
        return $this->render('AppBundle:Form:index.html.twig',
            array('forms'=>$forms,'title'=>'Formularios con respuestas','mode'=>'results'));
    }

    /**
     * @Route("/results/view", name="view_result")
     * @Security("has_role('ROLE_ADMINISTRATOR')")
     */
    public function viewResultAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formId = $request->get("id");

        $form = $em->getRepository('AppBundle:Form')->find($formId);
        $results = $em->getRepository('AppBundle:Answer')->findResultFormByQuestion($formId);

        $totalAnswers = $em->getRepository('AppBundle:Answer')->amountUsersAnswerForm($formId);
        $questions = $em->getRepository('AppBundle:Question')->getQuestionsByForm($formId);

        return $this->render('AppBundle:Answer:results.html.twig',
            array('results'=>$results,'form'=>$form,'choices'=>Question::$choices,'totalAnswers'=>$totalAnswers,
                'questions'=>$questions));
    }

    /**
     * @Route("/results/news", name="result_news")
     * @Security("has_role('ROLE_ADMINISTRATOR')")
     */
    public function newsResultAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $amountUsersAnswers = $request->get("usersAnswers");
        $formId = $request->get("formId");
        $totalAnswers = $em->getRepository('AppBundle:Answer')->amountUsersAnswerForm($formId);
        if($amountUsersAnswers!=$totalAnswers){

            return $this->forward('AppBundle:Answer:viewResult', array(
                'id'  => $formId
            ));
        }else{
            return new Response(0);
        }
    }

}

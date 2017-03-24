<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Form;
use AppBundle\Entity\Question;
use AppBundle\Form\FormType;
use Assetic\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends Controller
{

    /**
     * @Route("/forms", name="forms")
     */
    public function formsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $forms=$em->getRepository('AppBundle:Form')->findAll();
        return $this->render('AppBundle:Form:index.html.twig',
            array('forms'=>$forms,'title'=>'List de formularios creados','admin'=>true));
    }


    /**
     * @Route("/forms/new", name="forms_new")
     */
    public function createFormAction($formPrev=null)
    {
        $newForm= new Form();
        $newQuestion= new Question();
        $newForm->addQuestion($newQuestion);

        $form = !$formPrev ? $this->createForm(FormType::class,$newForm) : $formPrev;


        $html= $this->renderView('AppBundle:Form:form.html.twig',
            array('form'=>$form->createView(),'question'=>null));
        if($formPrev)
        {
           return new Response($html);
        }else{
            return $this->render('AppBundle:Form:create.html.twig',
                array('html'=>$html));
        }

    }

    /**
     * @Route("/forms/save", name="forms_save")
     */
    public function saveFormAction(Request $request)
    {


        $form = $this->createForm(FormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            try {
                $em->flush();
                return new Response(1);
            }catch (\Exception $e){
                throw new \Exception("Error al guardar");
            }
        }else{
            return $this->createFormAction($form);
        }
    }
}

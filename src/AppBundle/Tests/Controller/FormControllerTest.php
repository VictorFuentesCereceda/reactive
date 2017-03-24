<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class FormControllerTest extends WebTestCase
{

    protected $em;
    protected $client;
    protected $_application;

    function setUp()
    {
        $this->client = static::createClient();
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $this->_application = new Application($kernel);
        $this->_application->setAutoExit(false);

        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testForms()
    {
        $this->login('admin@reactive.cl','administrador');
        $crawler =  $this->client->request('GET', '/forms');
        $this->assertEquals(1, $crawler->filter('html:contains("Lista de formularios creados")')->count());
    }

    public function testFormsUser()
    {
        $this->login('user@reactive.cl','usuario');
        $crawler =  $this->client->request('GET', '/forms');
        $this->assertEquals(0, $crawler->filter('html:contains("Lista de formularios creados")')->count());
    }

    public function testResults()
    {
        $this->login('admin@reactive.cl','administrador');
        $crawler =  $this->client->request('GET', '/results');
        $this->assertEquals(1, $crawler->filter('html:contains("Formularios con respuestas")')->count());
    }

    public function testformsAnswer()
    {
        $this->login('usuario@reactive.cl','usuario');
        $crawler =  $this->client->request('GET', '/forms/answer');
        $this->assertEquals(1, $crawler->filter('html:contains("Formularios para responder")')->count());
    }


    public function testCreateForm()
    {
        $this->login('admin@reactive.cl','administrador');


        $crawler = $this->client->request('POST', '/forms/new');

        $form=$crawler->filter('form[name=appbundle_form]')->form();

        $values['appbundle_form']['name']= "Nuevo formulario";
        $values['appbundle_form']['questions'][0]['question']= "Pregunta 1";
        $values['appbundle_form']['questions'][1]['question']= "Pregunta 2";
        $values['appbundle_form']['_token']= $form['appbundle_form[_token]']->getValue();

        $this->client->submit($form);

        $this->client->request('POST', '/forms/save', $values);

        $this->assertEquals(1,$this->client->getResponse()->getContent());
    }

    public function testCreateFormWithoutName()
    {
        $this->login('admin@reactive.cl','administrador');

        $crawler = $this->client->request('POST', '/forms/new');
        $form=$crawler->filter('form[name=appbundle_form]')->form();

        $values['appbundle_form']['questions'][0]['question']= "Pregunta 1";
        $values['appbundle_form']['questions'][1]['question']= "Pregunta 2";
        $values['appbundle_form']['_token']= $form['appbundle_form[_token]']->getValue();

        $this->client->submit($form);
        $this->client->request('POST', '/forms/save', $values);

        $this->assertNotEquals(1,$this->client->getResponse()->getContent());
    }

    public function testResultsUser()
    {
        $this->login('user@reactive.cl','usuario');
        $crawler =  $this->client->request('GET', '/results');
        $this->assertEquals(0, $crawler->filter('html:contains("Formularios con respuestas")')->count());
    }

    public function login($user,$pass){
        $crawler =  $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Ingresar');
        $form = $buttonCrawlerNode->form();
        $data = array('_username' => $user,'_password' => $pass);
        $this->client->submit($form,$data);
    }
}

<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
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

    public function testIndexUsuario()
    {
        $this->login('usuario@reactive.cl','usuario');
        $crawler =  $this->client->request('GET', '/');
        $this->assertEquals(1, $crawler->filter('html:contains("Formularios para responder")')->count());
    }

    public function testIndexAdmin()
    {
        $this->login('admin@reactive.cl','administrador');
        $crawler =  $this->client->request('GET', '/');
        $this->assertEquals(1, $crawler->filter('html:contains("Lista de formularios creados")')->count());
    }

    public function login($user,$pass){
        $crawler =  $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Ingresar');
        $form = $buttonCrawlerNode->form();
        $data = array('_username' => $user,'_password' => $pass);
        $this->client->submit($form,$data);
    }
}

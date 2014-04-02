<?php

namespace Exina\AdminBundle\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class OrderControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testJsonListWithAuthentication()
    {
        $this->login();

        $crawler = $this->client->request('GET', '/admin/order/list/json');

        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    public function testJsonListWithoutAuthentication()
    {
        $this->client->request('GET', '/admin/order/list/json');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    private function login()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

}

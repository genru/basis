<?php

namespace Exina\AdminBundle\Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LicenseControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        self::runCommand("propel:fixtures:load @ExinaAdminBundle --yml");
    }

    public function testProductActivat()
    {
        $this->client->request('POST', '/v1/active/1', array('key'=>'111111', 'host'=>'E0011'));
        $this->assertEquals(
            201,
            $this->client->getResponse()->getStatusCode()
        );

        $this->client->request('POST', '/v1/active/1', array('key'=>'111111', 'host'=>'E0012'));
        $this->assertEquals(
            400,
            $this->client->getResponse()->getStatusCode()
        );

        $this->client->request('POST', '/v1/active/1', array('key'=>'22222', 'host'=>'E0011'));
        $this->assertEquals(
            402,
            $this->client->getResponse()->getStatusCode()
        );
    }

}

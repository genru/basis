<?php

namespace Exina\AdminBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Exina\AdminBundle\Model\Customer;
use Exina\AdminBundle\Model\Order;
use Exina\AdminBundle\Model\Host;

class PayPalListener {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function onIPNReceive(PayPalEvent $event) {
        // $ipn = $event->getIPN();
        // do your stuff

       //$customer = new Customer();
       //$customer->setName("john Doe");
       //$customer->setEmail("john@pais.com");
       //$customemr->setOrganization("Paypal Inc.");
	//$customer->save();

        $p = new Host();
	$p->setFingerprint("ssss");
  	$p->save();
	$response = $event->getResponse();
	$response->setStatusCode(520, "failed");
    }
}

<?php

namespace Exina\AdminBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;

class PayPalListener {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function onIPNReceive(PayPalEvent $event) {
        $ipn = $event->getIPN();
        // do your stuff
    }
}

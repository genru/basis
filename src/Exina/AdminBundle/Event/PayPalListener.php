<?php

namespace Exina\AdminBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Exina\AdminBundle\Model\Customer;
use Exina\AdminBundle\Model\Order;
use Exina\AdminBundle\Model\Product;
use Exina\AdminBundle\Model\ProductQuery;

class PayPalListener {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function onIPNReceive(PayPalEvent $event) {
        $ipn = $event->getIPN();
        // do your stuff

        $ipnOrder = $ipn->getOrder();
        $customer = new Customer();
        $customer->setName($ipnOrder->getAddressName());
        $customer->setEmail($ipnOrder->getPayerEmail());
        $customer->setOrganization($ipnOrder->getPayerBusinessName());
        $customer->save();

        $product = ProductQuery::create()->findPk();

        $p = new Host();
        $p->setFingerprint("newss");
        $p->save();
    }
}

<?php

namespace Exina\AdminBundle\Event;

use Orderly\PayPalIpnBundle\Event\PayPalEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Exina\AdminBundle\Model\Customer;
use Exina\AdminBundle\Model\Order;
use Exina\AdminBundle\Model\OrderPeer;
use Exina\AdminBundle\Model\OrderItem;
use Exina\AdminBundle\Model\Product;
use Exina\AdminBundle\Model\ProductQuery;

use Exina\AdminBundle\Model\Key;
use Exina\AdminBundle\Model\KeyPeer;
use Exina\AdminBundle\Model\KeyQuery;

class PayPalListener {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function onIPNReceive(PayPalEvent $event) {
        $ipn = $event->getIPN();
        // do your stuff

        $ipnOrder = $ipn->getOrder();
        $items = $ipn->getOrderItems();

        $customer = new Customer();
        $customer->setName($ipnOrder->getFirstName().' '.$ipnOrder->getLastName());
        $customer->setEmail($ipnOrder->getPayerEmail());
        $customer->setOrganization($ipnOrder->getPayerBusinessName());
        $customer->setCountry($ipnOrder->getAddressCountry());
        // $customer->save();

        $order = new Order();
        $order->setAgent("Paypal Instance");
        $order->setTransId($ipnOrder->getTxnId());
        if($ipn->getOrderStatus()==='PAID')
            $order->setState(OrderPeer::STATE_PAID);
        else
            $order->setState(OrderPeer::STATE_PENDING);
        $order->setCustomer($customer);
        $order->setGross($ipnOrder->getMcGross());

        foreach ($items as $item) {
            # code...
            $product = ProductQuery::create()->findPk($item->getItemNumber());
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->save();
        }

        // assgin key for a order
        $product = ProductQuery::create()->findPk($items[0]->getItemNumber());
        $EMPTY_ORDER = new Order();
        $key = KeyQuery::create()
            ->filterByProduct($product)
            ->filterByProduct($EMPTY_ORDER)
            ->findOne();
        $order->setProductKey($key);
    }
}

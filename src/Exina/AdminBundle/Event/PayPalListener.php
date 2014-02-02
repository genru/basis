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
        $customer->setName($ipnOrder->getAddressName());
        $customer->setEmail($ipnOrder->getPayerEmail());
        $customer->setOrganization($ipnOrder->getPayerBusinessName());
        // $customer->save();

        $order = new Order();
        $order->setAgent("Paypal Instance");
        $order->setTransId($ipnOrder->getTxnId());
        if($ipn->getOrderStatus()==IPN::PAID)
            $order->setState(OrderPeer::STATE_PAID);
        else
            $order->setState(OrderPeer::STATE_PENDING);
        $order->setCustomer($customer);

        foreach ($items as $item) {
            # code...
            $product = ProductQuery::create()->findPk($item->getItemNumber());
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->save();
        }
    }
}

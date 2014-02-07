<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Exina\AdminBundle\Model\Order;
use Exina\AdminBundle\Model\OrderQuery;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('exina_admin_dashboard'));
    }

    public function chartsAction()
    {
        # last 30 days orders
        $monthlyOrders = OrderQuery::create()
            ->filterByCreatedAt(array('min' => time() - 30 * 24 * 60 * 60))
            ->orderByCreatedAt()
            ->find();
        $monthly = array();
        $monthly['sum'] = 0;
        $monthly['array'] = array();
        foreach($monthlyOrders as $order)
        {
            $monthly['array'][] = $order->getGross();
            $monthly['sum'] += $order->getGross();
        }

        # last 7 days orders
        $weeklyOrders = OrderQuery::create()
            ->filterByCreatedAt(array('min' => time() - 7 * 24 * 60 * 60))
            ->orderByCreatedAt()
            ->find();
        $weekly = array();
        $weekly['sum'] = 0;
        $weekly['array'] = array();
        foreach($weeklyOrders as $order)
        {
            $weekly['array'][] = $order->getGross();
            $weekly['sum'] += $order->getGross();
        }

        return $this->render('ExinaAdminBundle:Default:index.html.twig', array('weekly' => $weekly, 'monthly'=>$monthly));
    }
}

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

        $weekly_sale = array(2,4,9,7,12,8,16);
        $weekly_sum = 345800;
        return $this->render('ExinaAdminBundle:Default:index.html.twig', array('weekly' => $weekly, 'monthly'=>$monthly));
    }
}

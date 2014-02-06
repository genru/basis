<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('exina_admin_dashboard'));
    }

    public function chartsAction()
    {
        $weekly_sale = array(2,4,9,7,12,8,16);
        $weekly_sum = 345800;
        $monthly_sale = array(20,15,18,14,10,13,9,7,6,8,3,11,11,13,6,24,10,8,9,13,11,6,10,11,9,10,6,16,10,6,9,9);
        $monthly_sum = 4356743;
        return $this->render('ExinaAdminBundle:Default:index.html.twig', array('weekly_sale' => $weekly_sale, 'monthly_sale' => $monthly_sale, 'weekly_sum' => $weekly_sum, 'monthly_sum' => $monthly_sum));
    }
}

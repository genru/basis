<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exina\AdminBundle\Model\Order;
use Exina\AdminBundle\Model\OrderPeer;
use Exina\AdminBundle\Model\OrderQuery;
use Exina\AdminBundle\Form\Type\OrderType;

class OrderController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('ex_admin_order_list'));
    }

    public function listAction()
    {
        $errors = null;
        $allOrder = OrderQuery::create()
            ->find();
        if($allOrder===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return $this->render('ExinaAdminBundle:Order:list.html.twig', array('orders'=>$allOrder, 'errors'=>$errors));
    }

    public function jsonListAction()
    {
        $errors = null;
        $allOrder = OrderQuery::create()
            ->find();
        if($allOrder===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return new JsonResponse([
            'ok' => $errors == null,
            'error'=>$errors,
            'data' => $allOrder->toArray()
        ]);
    }

    public function createAction(Request $request)
    {
        $errors = null;
        $order = new Order();

        $form = $this->createForm(new OrderType(), $order);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $order = $form->getData();
                $order->save();
                return $this->redirect($this->generateUrl('ex_admin_order_list'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($order);
        }

        return $this->render('ExinaAdminBundle:Order:new.html.twig', array('form' => $form->createView(),
                'errors'     => $errors,
                'order'       => $order,
                ));

    }

    public function updateAction(Request $request, $id)
    {
        $errors = null;
        $order = OrderQuery::create()->findPk($id);
        if($order==null)
            throw new Exception("Error record not exist", 500);

        // $form = $this->createFormBuilder( $order)
        //     ->add('productOrder')
        //     ->add('product', 'model', array(
        //         'class' => 'Exina\AdminBundle\Model\Product',
        //         'property' => 'name',
        //         'multiple' => false,
        //         'attr' => array('data-placeholder' => '-')))
        //     ->add('order', 'model', array(
        //         'class' => 'Exina\AdminBundle\Model\Order',
        //         'property' => 'trans_id',
        //         'multiple' => false,
        //         'attr' => array('data-placeholder' => '-'),))
        //    ->add('host', 'model', array(
        //         'class' => 'Exina\AdminBundle\Model\Host',
        //         'property' => 'fingerprint',
        //         'multiple' => false,
        //         'attr' => array('data-placeholder' => '-'),))
        //     ->add('createdAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true))
        //     ->add('updatedAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true))
        //     ->getForm();

        $form = $this->createForm(new OrderType(true), $order);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $order = $form->getData();
                $order->save();
                return $this->redirect($this->generateUrl('ex_admin_order_home'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($order);
        }

        return $this->render('ExinaAdminBundle:Order:update.html.twig', array('form' => $form->createView(),
                'errors' => $errors, 'order'=>$order,));
    }

    public function deleteAction($id)
    {
        $order = OrderQuery::create()->findPk($id);
        if($order==null)
            throw $this->createNotFoundException('recorder not exists');
        $order->delete();
        return $this->redirect($this->generateUrl('ex_admin_order_list'));
    }
}

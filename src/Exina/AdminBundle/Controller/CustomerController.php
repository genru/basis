<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Exina\AdminBundle\Model\Customer;
use Exina\AdminBundle\Model\CustomerPeer;
use Exina\AdminBundle\Model\CustomerQuery;
use Exina\AdminBundle\Form\Type\CustomerType;

class CustomerController extends Controller
{
    public function listAction()
    {
        $errors = null;
        $allCustomer = CustomerQuery::create()
            ->find();
        if($allCustomer===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return $this->render('ExinaAdminBundle:Customer:list.html.twig', array('customers'=>$allCustomer, 'errors'=>$errors));
    }

    public function createAction(Request $request)
    {
        $errors = null;
        $customer = new Customer();

        $form = $this->createForm(new CustomerType(), $customer);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $customer = $form->getData();
                $customer->save();
                return $this->redirect($this->generateUrl('ex_admin_customer_list'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($customer);
        }

        return $this->render('ExinaAdminBundle:Customer:new.html.twig', array('form' => $form->createView(),
                'errors'     => $errors,
                'customer'       => $customer,
                ));

    }

    public function updateAction(Request $request, $id)
    {
        $errors = null;
        $customer = CustomerQuery::create()->findPk($id);
        if($customer==null)
            throw new Exception("Error record not exist", 500);

        $form = $this->createForm(new CustomerType(true), $customer);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $customer = $form->getData();
                $customer->save();
                return $this->redirect($this->generateUrl('ex_admin_customer_home'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($customer);
        }

        return $this->render('ExinaAdminBundle:Customer:update.html.twig', array('form' => $form->createView(),
                'errors' => $errors, 'customer'=>$customer,));
    }

    public function deleteAction($id)
    {
        $customer = CustomerQuery::create()->findPk($id);
        if($customer==null)
            throw $this->createNotFoundException('recorder not exists');
        $customer->delete();
        return $this->redirect($this->generateUrl('ex_admin_customer_list'));
    }
}

<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Exina\AdminBundle\Model\Product;
use Exina\AdminBundle\Model\ProductPeer;
use Exina\AdminBundle\Model\ProductQuery;
use Exina\AdminBundle\Form\Type\ProductType;

class ProductController extends Controller
{
    public function listAction()
    {
        $errors = null;
        $allProduct = ProductQuery::create()
            ->find();
        if($allProduct===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return $this->render('ExinaAdminBundle:Product:list.html.twig', array('products'=>$allProduct, 'errors'=>$errors));
    }

    public function createAction(Request $request)
    {
        $errors = null;
        $product = new Product();

        $form = $this->createForm(new ProductType(), $product);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $product = $form->getData();
                $product->save();
                return $this->redirect($this->generateUrl('ex_admin_product_list'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($product);
        }

        return $this->render('ExinaAdminBundle:Product:new.html.twig', array('form' => $form->createView(),
                'errors'     => $errors,
                'product'       => $product,
                ));

    }

    public function updateAction(Request $request, $id)
    {
        $errors = null;
        $product = ProductQuery::create()->findPk($id);
        if($product==null)
            throw new Exception("Error record not exist", 500);

        // $form = $this->createFormBuilder( $product)
        //     ->add('name')
        //     ->add('createdAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true))
        //     ->add('updatedAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true))
        //     ->getForm();
        $form = $this->createForm(new ProductType(true), $product);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $product = $form->getData();
                $product->save();
                return $this->redirect($this->generateUrl('ex_admin_product_home'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($product);
        }

        return $this->render('ExinaAdminBundle:Product:update.html.twig', array('form' => $form->createView(),
                'errors' => $errors, 'product'=>$product,));
    }

    public function deleteAction($id)
    {
        $product = ProductQuery::create()->findPk($id);
        if($product==null)
            throw $this->createNotFoundException('recorder not exists');
        $product->delete();
        return $this->redirect($this->generateUrl('ex_admin_product_list'));
    }
}

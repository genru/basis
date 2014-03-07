<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Exina\AdminBundle\Model\Key;
use Exina\AdminBundle\Model\KeyPeer;
use Exina\AdminBundle\Model\KeyQuery;
use Exina\AdminBundle\Form\Type\KeyType;

class KeyController extends Controller
{
    public function listAction()
    {
        $errors = null;
        $allKey = KeyQuery::create()
            ->find();
        if($allKey===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return $this->render('ExinaAdminBundle:Key:list.html.twig', array('keys'=>$allKey, 'errors'=>$errors));
    }

    public function createAction(Request $request)
    {
        $errors = null;
        $key = new Key();

        $form = $this->createForm(new KeyType(), $key);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $key = $form->getData();
                $key->save();
                return $this->redirect($this->generateUrl('ex_admin_key_list'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($key);
        }

        return $this->render('ExinaAdminBundle:Key:new.html.twig', array('form' => $form->createView(),
                'errors'     => $errors,
                'key'       => $key,
                ));
    }

    public function updateAction(Request $request, $id)
    {
        $errors = null;
        $key = KeyQuery::create()->findPk($id);
        if($key==null)
            throw new Exception("Error record not exist", 500);

        // $form = $this->createFormBuilder( $key)
        //     ->add('productKey')
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
        //         ->add('updatedAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true))
        //         ->getForm();

        $form = $this->createForm(new KeyType(true), $key);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $key = $form->getData();
                $key->save();
                return $this->redirect($this->generateUrl('ex_admin_key_home'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($key);
        }

        return $this->render('ExinaAdminBundle:Key:update.html.twig', array('form' => $form->createView(),
                'errors' => $errors, 'key'=>$key,));
    }

    public function deleteAction($id)
    {
        $key = KeyQuery::create()->findPk($id);
        if($key==null)
            throw $this->createNotFoundException('recorder not exists');
        $key->delete();
        return $this->redirect($this->generateUrl('ex_admin_key_list'));
    }
}

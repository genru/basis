<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Exina\AdminBundle\Model\Host;
use Exina\AdminBundle\Model\HostPeer;
use Exina\AdminBundle\Model\HostQuery;
use Exina\AdminBundle\Form\Type\HostType;

class HostController extends Controller
{
    public function listAction()
    {
        $errors = null;
        $allHost = HostQuery::create()
            ->find();
        if($allHost===null) {
            $errors = array();
            $errors[] = array('message'=>'No data');
        }

        return $this->render('ExinaAdminBundle:Host:list.html.twig', array('hosts'=>$allHost, 'errors'=>$errors));
    }

    public function createAction(Request $request)
    {
        $errors = null;
        $host = new Host();

        $form = $this->createForm(new HostType(), $host);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $host = $form->getData();
                $host->save();
                return $this->redirect($this->generateUrl('ex_admin_host_list'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($host);
        }

        return $this->render('ExinaAdminBundle:Host:new.html.twig', array('form' => $form->createView(),
                'errors'     => $errors,
                'host'       => $host,
                ));

    }

    public function updateAction(Request $request, $id)
    {
        $errors = null;
        $host = HostQuery::create()->findPk($id);
        if($host==null)
            throw new Exception("Error record not exist", 500);

        $form = $this->createForm(new HostType(true), $host);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $host = $form->getData();
                $host->save();
                return $this->redirect($this->generateUrl('ex_admin_host_home'));
            }
            $validator = $this->get('validator');
            $errors = $validator->validate($host);
        }

        return $this->render('ExinaAdminBundle:Host:update.html.twig', array('form' => $form->createView(),
                'errors' => $errors, 'host'=>$host,));
    }

    public function deleteAction($id)
    {
        $host = HostQuery::create()->findPk($id);
        if($host==null)
            throw $this->createNotFoundException('recorder not exists');
        $host->delete();
        return $this->redirect($this->generateUrl('ex_admin_host_list'));
    }
}

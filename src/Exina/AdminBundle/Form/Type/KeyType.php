<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class KeyType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Exina\AdminBundle\Model\Key',
        'name'       => 'key',
    );

    private $update_form = false;

    public function __construct($update_form = false)
    {
        $this->update_form = $update_form;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productKey');
        $builder->add('product', 'model', array(
            'class' => 'Exina\AdminBundle\Model\Product',
            'property' => 'name',
            'multiple' => false,
            'attr' => array('data-placeholder' => '-')));
        if($this->update_form)
        {
            $builder->add('order', 'model', array(
                'class' => 'Exina\AdminBundle\Model\Order',
                'property' => 'trans_id',
                'multiple' => false,
                'attr' => array('data-placeholder' => '-'),
                'choices' => null,));
            $builder->add('host', 'model', array(
                'class' => 'Exina\AdminBundle\Model\Host',
                'property' => 'fingerprint',
                'multiple' => false,
                'attr' => array('data-placeholder' => '-'),));
            $builder->add('createdAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true));
            $builder->add('updatedAt', 'datetime', array('widget'=>'single_text', 'read_only'=>true));
        }
        else
        {
            $builder->add('createdAt', 'hidden');
            $builder->add('updatedAt', 'hidden');
        }
    }
}

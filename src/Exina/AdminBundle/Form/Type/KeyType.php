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
        $builder->add('order', 'model', array(
            'class' => 'Exina\AdminBundle\Model\Order',
            'property' => 'trans_id',
            'multiple' => false,
            'attr' => array('data-placeholder' => '-'),));
        $builder->add('host', 'model', array(
            'class' => 'Exina\AdminBundle\Model\Host',
            'property' => 'fingerprint',
            'multiple' => false,
            'attr' => array('data-placeholder' => '-'),));
        $builder->add('createdAt', 'hidden');
        $builder->add('updatedAt', 'hidden');
    }
}

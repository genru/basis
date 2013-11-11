<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderItemType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Exina\AdminBundle\Model\OrderItem',
        'name'       => 'orderitem',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('orderId');
        $builder->add('product', 'model', array(
            'class' => 'Exina\AdminBundle\Model\Product',
            'property' => 'name',
            'multiple' => false,
            'attr' => array('data-placeholder' => '-')));
        $builder->add('quantity');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }
}

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
        $builder->add('productId');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }
}

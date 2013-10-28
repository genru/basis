<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class KeyType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Acme\DemoBundle\Model\Key',
        'name'       => 'key',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productkey');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }
}

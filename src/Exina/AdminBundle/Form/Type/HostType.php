<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HostType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Acme\DemoBundle\Model\Host',
        'name'       => 'host',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fingerprint');
        $builder->add('createdAt');
        $builder->add('updatedAt');
    }
}

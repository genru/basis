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
        $builder->add('createdAt', 'hidden');
        $builder->add('updatedAt', 'hidden');
    }
}

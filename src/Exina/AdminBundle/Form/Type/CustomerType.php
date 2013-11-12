<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Exina\AdminBundle\Model\Customer',
        'name'       => 'customer',
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
        $builder->add('name');
        $builder->add('email');
        $builder->add('organization');
        if($this->update_form)
        {
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

<?php

namespace Exina\AdminBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Exina\AdminBundle\Model\Product',
        'name'       => 'product',
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

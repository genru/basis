<?php

namespace Exina\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'basis_order' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Exina.AdminBundle.Model.map
 */
class OrderTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Exina.AdminBundle.Model.map.OrderTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('basis_order');
        $this->setPhpName('Order');
        $this->setClassname('Exina\\AdminBundle\\Model\\Order');
        $this->setPackage('src.Exina.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('agent', 'Agent', 'VARCHAR', false, 255, null);
        $this->addColumn('trans_id', 'TransId', 'VARCHAR', false, 255, null);
        $this->getColumn('trans_id', false)->setPrimaryString(true);
        $this->addColumn('state', 'State', 'ENUM', false, null, null);
        $this->getColumn('state', false)->setValueSet(array (
  0 => 'PAID',
  1 => 'PENDING',
  2 => 'REFUNDED',
  3 => 'CANCELLED',
));
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'basis_customer', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', 'Exina\\AdminBundle\\Model\\Customer', RelationMap::MANY_TO_ONE, array('customer_id' => 'id', ), null, null);
        $this->addRelation('Key', 'Exina\\AdminBundle\\Model\\Key', RelationMap::ONE_TO_MANY, array('id' => 'order_id', ), null, null, 'Keys');
        $this->addRelation('OrderItem', 'Exina\\AdminBundle\\Model\\OrderItem', RelationMap::ONE_TO_MANY, array('id' => 'order_id', ), null, null, 'OrderItems');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // OrderTableMap

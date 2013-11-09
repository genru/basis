<?php

namespace Exina\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'basis_key' table.
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
class KeyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Exina.AdminBundle.Model.map.KeyTableMap';

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
        $this->setName('basis_key');
        $this->setPhpName('Key');
        $this->setClassname('Exina\\AdminBundle\\Model\\Key');
        $this->setPackage('src.Exina.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('product_key', 'ProductKey', 'VARCHAR', false, 255, null);
        $this->addForeignKey('product_id', 'ProductId', 'INTEGER', 'basis_product', 'id', true, null, null);
        $this->addForeignKey('order_id', 'OrderId', 'INTEGER', 'basis_order', 'id', false, null, null);
        $this->addForeignKey('host_id', 'HostId', 'INTEGER', 'basis_host', 'id', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', 'Exina\\AdminBundle\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), null, null);
        $this->addRelation('Order', 'Exina\\AdminBundle\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), null, null);
        $this->addRelation('Host', 'Exina\\AdminBundle\\Model\\Host', RelationMap::MANY_TO_ONE, array('host_id' => 'id', ), null, null);
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

} // KeyTableMap

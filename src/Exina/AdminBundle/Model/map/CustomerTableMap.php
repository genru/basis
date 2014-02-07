<?php

namespace Exina\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'basis_customer' table.
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
class CustomerTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Exina.AdminBundle.Model.map.CustomerTableMap';

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
        $this->setName('basis_customer');
        $this->setPhpName('Customer');
        $this->setClassname('Exina\\AdminBundle\\Model\\Customer');
        $this->setPackage('src.Exina.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 80, null);
        $this->addColumn('organization', 'Organization', 'VARCHAR', false, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Order', 'Exina\\AdminBundle\\Model\\Order', RelationMap::ONE_TO_MANY, array('id' => 'customer_id', ), null, null, 'Orders');
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

} // CustomerTableMap

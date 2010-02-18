<?php
/**
 * DoctrineExtensions PHPUnit
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\PHPUnit;

use Doctrine\DBAL\Schema\AbstractSchemaManager;

class DoctrineMetadata implements \PHPUnit_Extensions_Database_DB_IMetaData
{
    /**
     * @var Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    private $_sm = null;

    /**
     * @var array
     */
    private $_tables = null;

    private $_schema = null;

    public function __construct(AbstractSchemaManager $sm, $schema)
    {
        $this->_sm = $sm;
        $this->_schema = $schema;
    }

    private function _loadTables()
    {
        if ($this->_tables === null) {
            $tables = $this->_sm->listTables();
            $this->_tables = array();
            foreach ($tables AS $table) {
                $this->_tables[strtolower($table->getName())] = $table;
            }
        }
    }

    /**
     * Returns an array containing the names of all the tables in the database.
     *
     * @return array
     */
    public function getTableNames()
    {
        $this->_loadTables();

        $tableNames = array();
        foreach ((array)$this->_tables AS $table) {
            $tableNames[] = $table->getName();
        }
        return $tableNames;
    }

    /**
     * Returns an array containing the names of all the columns in the
     * $tableName table,
     *
     * @param string $tableName
     * @return array
     */
    public function getTableColumns($tableName)
    {
        $table = $this->_getTable($tableName);
        
        $columnNames = array();
        foreach ($table->getColumns() AS $column) {
            $columnNames[] = $column->getName();
        }

        return $columnNames;
    }

    private function _getTable($tableName)
    {
        $this->_loadTables();

        $tableName = strtolower($tableName);
        if (isset($this->_tables[$tableName])) {
            return $this->_tables[$tableName];
        } else {
            throw new TestException("Table '".$tableName."' does not exist in database.");
        }
    }

    /**
     * Returns an array containing the names of all the primary key columns in
     * the $tableName table.
     *
     * @param string $tableName
     * @return array
     */
    public function getTablePrimaryKeys($tableName)
    {
        /* @var $table Doctrine\DBAL\Schema\Table */
        $table = $this->_getTable($tableName);

        $primaryKey = $table->getPrimaryKey();

        return $primaryKey->getColumns();
    }

    /**
     * Returns the name of the default schema.
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * Returns a quoted schema object. (table name, column name, etc)
     *
     * @param string $object
     * @return string
     */
    public function quoteSchemaObject($object)
    {
        return $this->_sm->getDatabasePlatform()->quoteIdentifier($object);
    }

    /**
     * Returns true if the rdbms allows cascading
     *
     * @return bool
     */
    public function allowsCascading()
    {
        return false;
    }
}
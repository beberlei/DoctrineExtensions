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

use Doctrine\DBAL\Connection;

class TestConnection implements \PHPUnit_Extensions_Database_DB_IDatabaseConnection
{
    /**
     * @var Connection
     */
    private $_conn = null;

    public function __construct(Connection $conn)
    {
        $this->_conn = $conn;
    }

    /**
     * Close this connection.
     */
    public function close()
    {
        $this->_conn->close();
    }

    /**
     * Creates a dataset containing the specified table names. If no table
     * names are specified then it will created a dataset over the entire
     * database.
     *
     * @param array $tableNames
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function createDataSet(Array $tableNames = NULL)
    {
        $ds = new DataSet\QueryDataSet($this);
        if (!is_array($tableNames)) {
            $tableNames = $this->getMetaData()->getTableNames();
        }

        foreach ($tableNames AS $tableName) {
            $ds->addTable($tableName);
        }
        return $ds;
    }

    /**
     * Creates a table with the result of the specified SQL statement.
     *
     * @param string $tableName
     * @param string $sql
     * @return PHPUnit_Extensions_Database_DataSet_ITable
     */
    public function createQueryTable($tableName, $sql)
    {
        return new DataSet\QueryTable($tableName, $sql, $this);
    }

    /**
     * Returns a Doctrine\DBAL\Connection Connection
     *
     * @return Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->_conn;
    }

    /**
     * Returns a database metadata object that can be used to retrieve table
     * meta data from the database.
     *
     * @return PHPUnit_Extensions_Database_DB_IMetaData
     */
    public function getMetaData()
    {
        return new DoctrineMetadata($this->_conn->getSchemaManager(), $this->_conn->getDatabase());
    }

    /**
     * Returns the number of rows in the given table. You can specify an
     * optional where clause to return a subset of the table.
     *
     * @param string $tableName
     * @param string $whereClause
     * @param int
     */
    public function getRowCount($tableName, $whereClause = NULL)
    {
        $sql = "SELECT count(*) FROM ".$tableName;
        if ($whereClause !== null) {
            $sql .= " WHERE ".$whereClause;
        }

        return $this->_conn->fetchColumn($sql);
    }

    /**
     * Returns the schema for the connection.
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->_conn->getDatabase();
    }

    /**
     * Returns a quoted schema object. (table name, column name, etc)
     *
     * @param string $object
     * @return string
     */
    public function quoteSchemaObject($object)
    {
        return $this->_conn->getDatabasePlatform()->quoteIdentifier($object);
    }

    /**
     * Returns the command used to truncate a table.
     *
     * @return string
     */
    public function getTruncateCommand()
    {
        throw new TestException('Not supported with this connection type');
    }

    /**
     * Returns true if the connection allows cascading
     *
     * @return bool
     */
    public function allowsCascading()
    {
        return false;
    }
}
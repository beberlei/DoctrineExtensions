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
use DoctrineExtensions\PHPUnit\Operations\Truncate;

require_once "PHPUnit/Extensions/Database/TestCase.php";
require_once 'PHPUnit/Extensions/Database/DataSet/QueryDataSet.php';
require_once 'PHPUnit/Extensions/Database/DataSet/QueryTable.php';

abstract class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var DoctrineExtensions\PHPUnit\TestConnection
     */
    private $_connection = null;

    /**
     * @return Doctrine\DBAL\Connection
     */
    abstract protected function getDoctrineConnection();

    /**
     * @return TestConnection
     */
    final protected function getConnection()
    {
        if ($this->_connection == null) {
            $this->_connection = new TestConnection($this->getDoctrineConnection());
        }
        return $this->_connection;
    }

    /**
     * Returns the database operation executed in test setup.
     *
     * @return \PHPUnit_Extensions_Database_Operation_DatabaseOperation
     */
    protected function getSetUpOperation()
    {
        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new Truncate(),
            new \PHPUnit_Extensions_Database_Operation_Insert()
        ));
    }

    /**
     * @param array $tableNames
     * @return \PHPUnit_Extensions_Database_DataSet_QueryDataSet
     */
    protected function createQueryDataSet(array $tableNames = null)
    {
        return $this->getConnection()->createDataSet($tableNames);
    }

    /**
     * @param  string $tableName
     * @param  string $sql
     * @return \PHPUnit_Extensions_Database_DataSet_QueryTable
     */
    protected function createQueryDataTable($tableName, $sql = null)
    {
        if ($sql == null) {
            $sql = 'SELECT * FROM '.$tableName;
        }

        return $this->getConnection()->createQueryTable($tableName, $sql);
    }
}
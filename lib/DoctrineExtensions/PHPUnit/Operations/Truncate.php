<?php
/**
 * Doctrine Extensions PHPUnit
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\PHPUnit\Operations;

use PHPUnit_Extensions_Database_Operation_IDatabaseOperation AS IDatabaseOperation;

class Truncate implements IDatabaseOperation
{
    protected $useCascade = FALSE;

    public function setCascade($cascade = TRUE)
    {
        $this->useCascade = $cascade;
    }

    public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, \PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
    {
        /* @var $connection DoctrineExtensions\PHPUnit\TestConnection */
        $conn = $connection->getConnection();

        foreach ($dataSet->getReverseIterator() as $table) {
            /* @var $table PHPUnit_Extensions_Database_DataSet_ITable */

            $tableName = $connection->quoteSchemaObject($table->getTableMetaData()->getTableName());

            $query = $conn->getDatabasePlatform()->getTruncateTableSql($tableName, $this->useCascade);

            try {
                $connection->getConnection()->executeUpdate($query);
            } catch (\Exception $e) {
                throw new \PHPUnit_Extensions_Database_Operation_Exception('TRUNCATE', $query, array(), $table, $e->getMessage());
            }
        }
    }
}
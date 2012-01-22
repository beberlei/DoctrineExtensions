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

namespace DoctrineExtensions\PHPUnit\DataSet;

class QueryTable extends \PHPUnit_Extensions_Database_DataSet_QueryTable
{
    protected function loadData()
    {
        if ($this->data === NULL) {
            $this->data = $this->databaseConnection->getConnection()->fetchAll($this->query);
        }
    }

    protected function createTableMetaData()
    {
        if ($this->tableMetaData === null) {
            $this->loadData();

            $columnNames = $this->databaseConnection
                                ->getMetaData()
                                ->getTableColumns($this->tableName);

            $this->tableMetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData(
                $this->tableName, $columnNames
            );
        }
    }
}

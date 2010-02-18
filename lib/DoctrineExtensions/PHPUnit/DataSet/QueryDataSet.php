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

class QueryDataSet extends \PHPUnit_Extensions_Database_DataSet_QueryDataSet
{
    public function addTable($tableName, $query = NULL)
    {
        if ($query === NULL) {
            $query = 'SELECT * FROM ' . $tableName;
        }

        $this->tables[$tableName] = new QueryTable($tableName, $query, $this->databaseConnection);
    }
}
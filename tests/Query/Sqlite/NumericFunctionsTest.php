<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

/**
 * This class is responsible for testing the SQLite numeric functions
 *
 * @author winkbrace
 */
class NumericFunctionsTest extends SqliteTestCase
{
    public function testRound()
    {
        $dql = 'SELECT ROUND(1.2345, 2) as outcome FROM DoctrineExtensions\Tests\Entities\Blank p';
        $q = $this->entityManager->createQuery($dql);
        $this->assertEquals("SELECT ROUND(1.2345, 2) AS {$this->columnAlias} FROM Blank b0_", $q->getSql());

        $dql = 'SELECT ROUND(1.2345) as outcome FROM DoctrineExtensions\Tests\Entities\Blank p';
        $q = $this->entityManager->createQuery($dql);
        $this->assertEquals("SELECT ROUND(1.2345) AS {$this->columnAlias} FROM Blank b0_", $q->getSql());
    }
}

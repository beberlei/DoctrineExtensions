<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class IfElse extends SqliteTestCase
{
    public function testIfElse()
    {
        $dql = "SELECT ifelse(1 > 0, 1, 0) FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b";

        $this->assertEquals(
            "SELECT CASE WHEN 1 > 0 THEN 1 ELSE 0 END AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }
}

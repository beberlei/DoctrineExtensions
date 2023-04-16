<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

final class ConcatWsTest extends SqliteTestCase
{
    public function testConcatWs()
    {
        $dql = "SELECT CONCAT_WS(',', p.id, p.name) FROM DoctrineExtensions\\Tests\\Entities\\Product p";

        $this->assertEquals(
            "SELECT (IFNULL(p0_.id, '') || ',' || IFNULL(p0_.name, '')) AS {$this->columnAlias} FROM Product p0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }
}

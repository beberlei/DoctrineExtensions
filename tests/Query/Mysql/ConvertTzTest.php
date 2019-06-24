<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ConvertTzTest extends MysqlTestCase
{
    public function testDefaultSql()
    {
        $query = $this->entityManager->createQuery(
            "SELECT CONVERT_TZ('2004-01-01 12:00:00','GMT','MET') FROM DoctrineExtensions\Tests\Entities\Blank b"
        );

        $this->assertEquals(
            "SELECT CONVERT_TZ('2004-01-01 12:00:00', 'GMT', 'MET') AS sclr_0 FROM Blank b0_",
            $query->getSql()
        );
    }
}

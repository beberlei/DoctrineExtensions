<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class WeekDayTest extends SqliteTestCase
{
    public function testFormatWeekDay()
    {
        $dql = 'SELECT WEEKDAY(b.created) FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b';
        $this->assertEquals(
            "SELECT CAST(STRFTIME('%w', b0_.created) AS NUMBER) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }
}

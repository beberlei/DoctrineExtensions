<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class WeekTest extends SqliteTestCase
{
    public function testFormatWeek(): void
    {
        $dql = 'SELECT WEEK(b.created) FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b';
        $this->assertEquals(
            "SELECT strftime('%W', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }

    public function testFormatWeekWithSecondArgument(): void
    {
        $dql = 'SELECT WEEK(b.created, 1) FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b';
        $this->assertEquals(
            "SELECT strftime('%W', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }
}

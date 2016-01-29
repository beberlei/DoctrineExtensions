<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class DateFormatTest extends SqliteTestCase
{
    public function testCommonFormats()
    {
        // Both result in '2015-12-30 14:23:40'
        $dql = "SELECT DATE_FORMAT(b.created, '%Y-%m-%d %H:%i:%S') FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b";

        $this->assertEquals(
            "SELECT STRFTIME('%Y-%m-%d %H:%M:%S', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }

    /**
     * Because sqlite does not support as many substitutions as mysql,
     * they get converted to the closest sqlite substitutions.
     * In this test a few examples are listed:
     */
    public function testUnsupportedFormats()
    {
        // Sqlite does not support AM / PM
        // mysql: '10:15:22 PM'
        // sqlite: '22:15:22'
        $dql = "SELECT DATE_FORMAT(b.created, '%r') FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b";

        $this->assertEquals(
            "SELECT STRFTIME('%H:%M:%S', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );

        // This is the worst case: Sqlite does not support ISO week numbers, so they get converted to %Y-%W
        // Mysql: "select date_format('2016-01-01', '%x-%v')" results in '2015-53'
        // Sqlite: "select date_format('2016-01-01', '%x-%v')" results in '2016-01'
        $dql = "SELECT DATE_FORMAT(b.created, '%x-%v') FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b";

        $this->assertEquals(
            "SELECT STRFTIME('%Y-%W', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );

        // Sqlite does not support weekday names, month names or month days with English suffix.
        // They all get converted to their numeric representations
        // Mysql: "Tuesday, November 10th, 2015"
        // Sqlite: "2, 11 10, 2015"
        $dql = "SELECT DATE_FORMAT(b.created, '%W, %M %D, %Y') FROM DoctrineExtensions\\Tests\\Entities\\BlogPost b";

        $this->assertEquals(
            "SELECT STRFTIME('%w, %m %d, %Y', b0_.created) AS {$this->columnAlias} FROM BlogPost b0_",
            $this->entityManager->createQuery($dql)->getSql()
        );
    }
}

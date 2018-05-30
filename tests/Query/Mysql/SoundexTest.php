<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SoundexTest extends MysqlTestCase
{
    public function testSoundex()
    {
        $this->assertDqlProducesSql(
            "SELECT SOUNDEX('2') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SOUNDEX('2') AS sclr_0 FROM Blank b0_"
        );
    }
}

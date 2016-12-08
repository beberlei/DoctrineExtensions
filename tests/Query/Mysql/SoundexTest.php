<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SoundexTest extends MysqlTestCase
{
    public function testSoundex()
    {
        $q = $this->entityManager->createQuery("SELECT SOUNDEX('2') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SOUNDEX('2') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}

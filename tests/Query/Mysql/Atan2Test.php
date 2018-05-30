<?php
namespace Query\Mysql;

class Atan2Test
{
    public function testAtan2()
    {
        $q = $this->entityManager->createQuery("SELECT ATAN2(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ATAN2(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}

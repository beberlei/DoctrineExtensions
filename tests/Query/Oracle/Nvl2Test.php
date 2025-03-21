<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

/** @author https://github.com/nxtpge */
class Nvl2Test extends OracleTestCase
{
    public function testNvl2(): void
    {
        $this->assertDqlProducesSql(
            'SELECT NVL2(p.name, \'expr1\', \'expr2\') FROM DoctrineExtensions\Tests\Entities\Product p',
            'SELECT NVL2(p0_.name, \'expr1\', \'expr2\') AS sclr_0 FROM Product p0_'
        );
    }
}

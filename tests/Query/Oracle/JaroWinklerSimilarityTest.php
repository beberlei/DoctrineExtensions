<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

/** @author https://github.com/nxtpge */
class JaroWinklerSimilarityTest extends OracleTestCase
{
    public function testJaroWinklerSimilarity(): void
    {
        $this->assertDqlProducesSql(
            'SELECT JARO_WINKLER_SIMILARITY(p.name, \'expr2\') FROM DoctrineExtensions\Tests\Entities\Product p',
            'SELECT UTL_MATCH.JARO_WINKLER_SIMILARITY(p0_.name, \'expr2\') AS sclr_0 FROM Product p0_'
        );
    }
}

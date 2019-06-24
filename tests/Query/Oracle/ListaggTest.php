<?php

namespace Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

/**
 * @author Alexey Kalinin <nitso@yandex.ru>
 */
class ListaggTest extends OracleTestCase
{
    public function testFullQuery()
    {
        $dql = "SELECT LISTAGG(p.id, ',') WITHIN GROUP (ORDER BY p.created) OVER (PARTITION BY p.longitude, p.latitude) FROM DoctrineExtensions\Tests\Entities\BlogPost p";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT LISTAGG(b0_.id, ',') WITHIN GROUP ( ORDER BY b0_.created ASC) PARTITION BY (b0_.longitude,b0_.latitude) AS sclr_0 FROM BlogPost b0_";
        $this->assertEquals($sql, $q->getSql());
    }
}

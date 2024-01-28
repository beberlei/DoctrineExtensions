<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Oracle;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Entities\Product;
use DoctrineExtensions\Tests\Query\OracleTestCase;

class CeilTest extends OracleTestCase
{
    public function testFullQuery(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder->select('CEIL(p.weight)')
            ->from(Product::class, 'p');

        $sql = 'SELECT CEIL(p0_.weight) AS sclr_0 FROM Product p0_';
        $this->assertEquals($sql, $queryBuilder->getQuery()->getSQL());
    }
}

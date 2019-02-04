<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query;

class PostgresqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::POSTGRES);
    }
}

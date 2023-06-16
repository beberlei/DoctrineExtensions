<?php

namespace DoctrineExtensions\Tests\Query;

class PostgresqlTestCase extends DbTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::POSTGRES);
    }
}

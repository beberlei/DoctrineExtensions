<?php

namespace DoctrineExtensions\Tests\Query;

abstract class PostgresqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::POSTGRES);
    }
}

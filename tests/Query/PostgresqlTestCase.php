<?php

namespace DoctrineExtensions\Tests\Query;

class PostgresqlTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::POSTGRES);
    }
}

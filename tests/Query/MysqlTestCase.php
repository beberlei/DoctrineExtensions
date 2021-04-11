<?php

namespace DoctrineExtensions\Tests\Query;

class MysqlTestCase extends DbTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::MYSQL);
    }
}

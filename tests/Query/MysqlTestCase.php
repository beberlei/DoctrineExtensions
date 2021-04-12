<?php

namespace DoctrineExtensions\Tests\Query;

abstract class MysqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::MYSQL);
    }
}

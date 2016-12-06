<?php

namespace DoctrineExtensions\Tests\Query;

class MysqlTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::MYSQL);
    }
}

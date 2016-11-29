<?php

namespace DoctrineExtensions\Tests\Query;

class OracleTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::ORACLE);
    }
}

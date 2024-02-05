<?php

namespace DoctrineExtensions\Tests\Query;

class OracleTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        ConfigLoader::load($this->configuration, ConfigLoader::ORACLE);
    }
}

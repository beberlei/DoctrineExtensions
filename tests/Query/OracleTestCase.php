<?php

namespace DoctrineExtensions\Tests\Query;

abstract class OracleTestCase extends DbTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::ORACLE);
    }
}

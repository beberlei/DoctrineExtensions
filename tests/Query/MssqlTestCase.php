<?php

namespace DoctrineExtensions\Tests\Query;

class MssqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::MSSQL);
    }
}

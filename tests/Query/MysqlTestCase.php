<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query;

class MysqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        ConfigLoader::load($this->configuration, ConfigLoader::MYSQL);
    }
}

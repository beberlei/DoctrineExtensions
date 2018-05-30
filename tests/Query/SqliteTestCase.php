<?php

namespace DoctrineExtensions\Tests\Query;

class SqliteTestCase extends DbTestCase
{
    /**
     * @var string name of Date.
     */
    protected $columnAlias;

    public function setUp()
    {
        parent::setUp();
        ConfigLoader::load($this->configuration, ConfigLoader::SQLITE);

        $emConfiguration = $this->entityManager->getConfiguration();

        if (method_exists($emConfiguration, 'getQuoteStrategy') === false) { // doctrine < 2.3
            $this->columnAlias = 'sclr0';
        } else {
            $this->columnAlias = $emConfiguration
                ->getQuoteStrategy()
                ->getColumnAlias(
                    'sclr',
                    0,
                    $this->entityManager->getConnection()->getDatabasePlatform(),
                    $this->entityManager->getClassMetadata('DoctrineExtensions\Tests\Entities\Date')
                );
        }
    }
}

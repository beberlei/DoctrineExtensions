<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Types\TimeImmutableType;

class CarbonImmutableTimeType extends TimeImmutableType
{
    use CarbonImmutableTypeImplementation;

    public const CARBONTIME = 'carbontime_immutable';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONTIME;
    }
}

<?php

namespace DoctrineExtensions\Types;

use Carbon\Doctrine\DateTimeImmutableType;

class CarbonImmutableDateTimeType extends DateTimeImmutableType
{
    use CarbonImmutableTypeImplementation;

    public const CARBONDATETIME = 'carbondatetime_immutable';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATETIME;
    }
}

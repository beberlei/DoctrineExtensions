<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Types\DateTimeTzImmutableType;

class CarbonImmutableDateTimeTzType extends DateTimeTzImmutableType
{
    use CarbonImmutableTypeImplementation;

    public const CARBONDATETIMETZ = 'carbondatetimetz_immutable';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATETIMETZ;
    }
}

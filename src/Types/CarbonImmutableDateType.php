<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Types\DateImmutableType;

class CarbonImmutableDateType extends DateImmutableType
{
    use CarbonImmutableTypeImplementation;

    public const CARBONDATE = 'carbondate_immutable';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATE;
    }
}

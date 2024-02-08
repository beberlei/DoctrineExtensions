<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Types\DateType;

class CarbonDateType extends DateType
{
    use CarbonTypeImplementation;

    public const CARBONDATE = 'carbondate';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATE;
    }
}

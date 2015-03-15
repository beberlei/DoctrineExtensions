<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\DateType;

class CarbonDateType extends DateType
{
    const CARBONDATE = 'carbondate';

    public function getName()
    {
        return static::CARBONDATE;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof \DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }
}

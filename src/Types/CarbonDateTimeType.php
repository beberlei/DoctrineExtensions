<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\DateTimeType;

class CarbonDateTimeType extends DateTimeType
{
    const CARBONDATETIME = 'carbondatetime';

    public function getName()
    {
        return static::CARBONDATETIME;
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

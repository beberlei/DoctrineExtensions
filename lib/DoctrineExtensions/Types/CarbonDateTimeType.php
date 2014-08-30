<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;
use Carbon\Carbon;

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

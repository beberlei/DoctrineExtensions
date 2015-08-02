<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\TimeType;

class CarbonTimeType extends TimeType
{
    const CARBONTIME = 'carbontime';

    public function getName()
    {
        return static::CARBONTIME;
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

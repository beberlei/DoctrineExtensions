<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

class CarbonDateType extends DateType
{
    const CARBONDATE = 'carbondate';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }
}

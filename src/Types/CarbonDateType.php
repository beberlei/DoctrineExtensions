<?php

declare(strict_types=1);

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

class CarbonDateType extends DateType
{
    public const CARBONDATE = 'carbondate';

    public function getName()
    {
        return self::CARBONDATE;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

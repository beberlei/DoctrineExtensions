<?php

declare(strict_types=1);

namespace DoctrineExtensions\Types;

use Carbon\CarbonImmutable;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class CarbonImmutableDateTimeType extends DateTimeType
{
    public const CARBONDATETIME = 'carbondatetime_immutable';

    public function getName()
    {
        return self::CARBONDATETIME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof DateTime) {
            return CarbonImmutable::instance($result);
        }

        return $result;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

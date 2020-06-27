<?php

namespace DoctrineExtensions\Types;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType;

class CarbonImmutableTimeType extends TimeType
{
    const CARBONTIME = 'carbontime_immutable';

    public function getName()
    {
        return static::CARBONTIME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof \DateTime) {
            return CarbonImmutable::instance($result);
        }

        return $result;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

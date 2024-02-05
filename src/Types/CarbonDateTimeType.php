<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class CarbonDateTimeType extends DateTimeType
{
    public const CARBONDATETIME = 'carbondatetime';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATETIME;
    }

    /**
     * {@inheritDoc}
     *
     * @return Carbon|DateTimeInterface
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

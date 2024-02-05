<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType;

class CarbonTimeType extends TimeType
{
    public const CARBONTIME = 'carbontime';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONTIME;
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

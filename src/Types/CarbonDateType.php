<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

class CarbonDateType extends DateType
{
    public const CARBONDATE = 'carbondate';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATE;
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

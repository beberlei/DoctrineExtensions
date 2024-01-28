<?php

namespace DoctrineExtensions\Types;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;

class CarbonImmutableDateTimeTzType extends DateTimeTzType
{
    public const CARBONDATETIMETZ = 'carbondatetimetz_immutable';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::CARBONDATETIMETZ;
    }

    /**
     * {@inheritDoc}
     *
     * @return CarbonImmutable|DateTimeInterface
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof DateTime) {
            return CarbonImmutable::instance($result);
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

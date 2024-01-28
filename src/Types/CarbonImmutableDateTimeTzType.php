<?php

declare(strict_types=1);

namespace DoctrineExtensions\Types;

use Carbon\CarbonImmutable;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;

class CarbonImmutableDateTimeTzType extends DateTimeTzType
{
    public const CARBONDATETIMETZ = 'carbondatetimetz_immutable';

    public function getName()
    {
        return self::CARBONDATETIMETZ;
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

<?php

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;

class CarbonDateTimeTzType extends DateTimeTzType
{
    const CARBONDATETIMETZ = 'carbondatetimetz';

    public function getName()
    {
        return static::CARBONDATETIMETZ;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof \DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

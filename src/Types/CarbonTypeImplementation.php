<?php

declare(strict_types=1);

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/** @internal */
trait CarbonTypeImplementation
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof CarbonImmutable) {
            $value = Carbon::instance($value);
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Carbon
    {
        $result = parent::convertToPHPValue($value, $platform);
        if ($result === null) {
            return null;
        }

        return Carbon::instance($result);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

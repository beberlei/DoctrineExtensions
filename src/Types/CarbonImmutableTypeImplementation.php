<?php

declare(strict_types=1);

namespace DoctrineExtensions\Types;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/** @internal */
trait CarbonImmutableTypeImplementation
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Carbon) {
            $value = CarbonImmutable::instance($value);
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CarbonImmutable
    {
        $result = parent::convertToPHPValue($value, $platform);
        if ($result === null) {
            return null;
        }

        return CarbonImmutable::instance($result);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

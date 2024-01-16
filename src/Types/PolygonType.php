<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Exception;

use function preg_match;
use function sprintf;

class PolygonType extends Type
{
    public const FIELD = 'polygon';

    public function getName(): string
    {
        return self::FIELD;
    }

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'POLYGON';
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): string
    {
        preg_match('/POLYGON\(\((.*)\)\)/', $value, $matches);
        if (! isset($matches[1])) {
            throw new Exception('No Polygon Points');
        }

        return $matches[1];
    }

    /**
     * {@inheritDoc}
     */
    public function convertToPHPValueSQL($sqlExpr, $platform): string
    {
        return sprintf('AsText(%s)', $sqlExpr);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return sprintf('POLYGON((%s))', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('ST_PolygonFromText(%s)', $sqlExpr);
    }
}

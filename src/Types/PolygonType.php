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

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::FIELD;
    }

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'POLYGON';
    }

    /**
     * {@inheritDoc}
     */
    public function canRequireSQLConversion()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
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
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return sprintf('AsText(%s)', $sqlExpr);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return sprintf('POLYGON((%s))', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('ST_PolygonFromText(%s)', $sqlExpr);
    }
}

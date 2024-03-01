<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Zend_Date;
use Zend_Locale_Format;

use function class_exists;

if (! class_exists('Zend_Date')) {
    require_once 'Zend/Date.php';
}

/**
 * Type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ZendDateType extends Type
{
    public const ZENDDATE = 'zenddate';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::ZENDDATE;
    }

    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value !== null
            ? $value->toString(Zend_Locale_Format::convertPhpToIsoFormat(
                $platform->getDateTimeFormatString()
            ))
            : null;
    }

    /**
     * {@inheritDoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Zend_Date
    {
        if ($value === null) {
            return null;
        }

        $dateTimeFormatString = Zend_Locale_Format::convertPhpToIsoFormat(
            $platform->getDateTimeFormatString()
        );

        return new Zend_Date($value, $dateTimeFormatString);
    }

    /**
     * {@inheritDoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}

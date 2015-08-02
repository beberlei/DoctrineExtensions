<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException,
    Doctrine\DBAL\Types\Type;

if (!class_exists('Zend_Date')) require_once 'Zend/Date.php';

/**
 * Type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ZendDateType extends Type
{
    const ZENDDATE = 'zenddate';

    public function getName()
    {
        return self::ZENDDATE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value !== null)
            ? $value->toString(\Zend_Locale_Format::convertPhpToIsoFormat(
                  $platform->getDateTimeFormatString()
              ))
            : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $dateTimeFormatString = \Zend_Locale_Format::convertPhpToIsoFormat(
            $platform->getDateTimeFormatString()
        );

        $val = new \Zend_Date($value, $dateTimeFormatString);
        if (!$val) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
        return $val;
    }
}

<?php

/*
 * DoctrineExtensions Types
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Types;

require_once 'Zend/Date.php';

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Types
 * @author      Andreas Gallien <gallien@seleos.de>
 * @license     New BSD License
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

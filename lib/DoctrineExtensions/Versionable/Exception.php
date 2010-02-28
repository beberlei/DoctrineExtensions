<?php
/**
 * DoctrineExtensions Versionable
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Versionable;

class Exception extends \Exception
{
    static public function versionedEntityRequired()
    {
        return new self("A versioned entity is required if implementing DoctrineExtnsions\Versionable\Versionable interface.");
    }

    static public function singleIdentifierRequired()
    {
        return new self('A single identifier column is required for the Versionable extension.');
    }

    static public function unknownVersion($version)
    {
        return new self('Trying to access an unknown version '.$version.'.');
    }
}
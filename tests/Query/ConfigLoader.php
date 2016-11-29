<?php
namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\Configuration;
use Symfony\Component\Yaml\Parser;

class ConfigLoader
{
    const MYSQL    = 'mysql';
    const ORACLE   = 'oracle';
    const POSTGRES = 'postgres';
    const SQLITE   = 'sqlite';

    /**
     * @param Configuration $configuration
     * @param string        $database
     */
    public static function load(Configuration $configuration, $database)
    {
        $parser = new Parser();
        // Load the corresponding config file.
        $parsed = $parser->parse( file_get_contents( realpath( __DIR__ . '/../../config/' . $database . '.yml' ) ) );

        // Make sure it has the correct structure.
        if (array_key_exists( 'doctrine', $parsed)) {
            if (array_key_exists('orm', $parsed['doctrine'])) {
                if (array_key_exists('dql', $parsed['doctrine']['orm'])) {
                    $parsed = $parsed['doctrine']['orm']['dql'];
                } else {
                    return;
                }
            } else {
                return;
            }
        } else {
            return;
        }

        // Load the existing function classes.
        foreach (array('datetime_functions', 'numeric_functions', 'string_functions') as $function) {
            if (array_key_exists($function, $parsed)) {
                foreach ($parsed[ $function ] as $key => $value) {
                    $configuration->addCustomDatetimeFunction(strtoupper($key), $value);
                }
            }
        }
    }
}

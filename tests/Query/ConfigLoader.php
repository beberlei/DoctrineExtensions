<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\Configuration;
use Symfony\Component\Yaml\Parser;

use function array_key_exists;
use function file_get_contents;
use function realpath;
use function strtoupper;

class ConfigLoader
{
    public const MYSQL = 'mysql';

    public const ORACLE = 'oracle';

    public const POSTGRES = 'postgres';

    public const SQLITE = 'sqlite';

    public static function load(Configuration $configuration, string $database): void
    {
        $parser = new Parser();
        // Load the corresponding config file.
        $config = $parser->parse(file_get_contents(realpath(__DIR__ . '/../../config/' . $database . '.yml')));
        $parsed = $config['doctrine']['orm']['dql'];

        // Load the existing function classes.
        if (array_key_exists('datetime_functions', $parsed)) {
            foreach ($parsed['datetime_functions'] as $key => $value) {
                $configuration->addCustomDatetimeFunction(strtoupper($key), $value);
            }
        }

        if (array_key_exists('numeric_functions', $parsed)) {
            foreach ($parsed['numeric_functions'] as $key => $value) {
                $configuration->addCustomNumericFunction(strtoupper($key), $value);
            }
        }

        if (array_key_exists('string_functions', $parsed)) {
            foreach ($parsed['string_functions'] as $key => $value) {
                $configuration->addCustomStringFunction(strtoupper($key), $value);
            }
        }
    }
}

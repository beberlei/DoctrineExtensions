<?php

namespace DoctrineExtensions\Tests\docs;

use DoctrineExtensions\Query\Mysql;

/**
 * Test that checks the README describes all of the query types
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ReadmeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->readme = file_get_contents(__DIR__ . '/../../README.md');
    }

    public function testMysqlFunctions()
    {
        preg_match_all('#\s+(.*): (DoctrineExtensions\\\Query\\\Mysql\\\.*)#', $this->readme, $matches);

        $documented = array_combine($matches[1], $matches[2]);

        $available = array_map(
            function ($path) {
                return 'DoctrineExtensions\\Query\\Mysql\\' . str_replace('.php', '', basename($path));
            },
            glob(__DIR__ . '/../../src/Query/Mysql/*')
        );

        $undocumented = array_diff($available, $documented);

        if ($undocumented) {
            $this->fail(
                "The following MySQL query functions are undocumented in README.md\n\n" .
                implode(PHP_EOL, $undocumented)
            );
        }
    }
}

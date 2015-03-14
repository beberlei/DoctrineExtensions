<?php

namespace DoctrineExtensions\Tests\Config;

/**
 * Test that checks the README describes all of the query types
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
class MysqlConfigTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $yaml = new \Symfony\Component\Yaml\Parser();

        $this->config = $yaml->parse(file_get_contents(__DIR__ . '/../../config/mysql.yml'));
    }

    public function testFunctions()
    {
        $documented = array_merge(
            $this->config['doctrine']['orm']['dql']['datetime_functions'],
            $this->config['doctrine']['orm']['dql']['numeric_functions'],
            $this->config['doctrine']['orm']['dql']['string_functions']
        );

        $available = array_map(
            function ($path) {
                return 'DoctrineExtensions\\Query\\Mysql\\' . str_replace('.php', '', basename($path));
            },
            glob(__DIR__ . '/../../src/Query/Mysql/*')
        );

        $undocumented = array_diff($available, $documented);

        if ($undocumented) {
            $this->fail(
                "The following MySQL query functions are undocumented in mysql.yml\n\n" .
                implode("\n", $undocumented)
            );
        }
    }
}

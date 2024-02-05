<?php

namespace DoctrineExtensions\Tests\Config;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;

use function array_diff;
use function array_keys;
use function array_map;
use function array_merge;
use function basename;
use function explode;
use function file_get_contents;
use function glob;
use function implode;
use function preg_match;
use function sort;
use function str_replace;
use function strtolower;

/**
 * Test that checks the README describes all of the query types
 */
class MysqlYamlTest extends TestCase
{
    /** @var array<string, string> */
    protected $functions;

    public function setUp(): void
    {
        $yaml = new Parser();

        $config          = $yaml->parse(file_get_contents(__DIR__ . '/../../config/mysql.yml'));
        $this->functions = array_merge(
            $config['doctrine']['orm']['dql']['datetime_functions'],
            $config['doctrine']['orm']['dql']['numeric_functions'],
            $config['doctrine']['orm']['dql']['string_functions']
        );
    }

    public function testFunctions(): void
    {
        $documented = $this->functions;

        $available = array_map(
            static function ($path) {
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
        } else {
            $this->assertEmpty($undocumented);
        }
    }

    public function testReadme(): void
    {
        preg_match('#\| MySQL \| `(.*)` \|#', file_get_contents(__DIR__ . '/../../README.md'), $matches);

        $docs = explode(', ', strtolower($matches[1]));
        $keys = array_keys($this->functions);

        sort($docs);
        sort($keys);

        $this->assertEquals($docs, $keys);
    }
}

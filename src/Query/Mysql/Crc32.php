<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * Crc32Function ::= "CRC32" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_crc32
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @example SELECT CRC32(foo.bar) FROM entity
 * @example SELECT CRC32('string')
 */
class Crc32 extends FunctionNode
{
    /** @var Node */
    public $stringPrimary;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'CRC32(' .
            $sqlWalker->walkStringPrimary($this->stringPrimary) .
        ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}

<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * InstrFunction ::= "INSTR" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_instr
 *
 * @example SELECT INSTR('foobar', 'bar')
 * @example SELECT INSTR(foo.bar, 'bar') FROM entity
 */
class Instr extends FunctionNode
{
    /** @var Node|string */
    public $originalString = null;

    /** @var Node|string */
    public $subString = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->originalString = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->subString = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'INSTR(%s, %s)',
            $this->originalString->dispatch($sqlWalker),
            $this->subString->dispatch($sqlWalker)
        );
    }
}

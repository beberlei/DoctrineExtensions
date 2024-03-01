<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * FromUnixTimeFunction ::= "FROM_UNIXTIME" "(" ArithmeticPrimary ["," ArithmeticPrimary] ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_from-unixtime
 *
 * @author Nima S <nimasdj@yahoo.com>
 * @example SELECT FROM_UNIXTIME(123456789)
 * @example SELECT FROM_UNIXTIME(foo.bar, '%Y') FROM entity
 */
class FromUnixtime extends FunctionNode
{
    /** @var Node|string */
    public $firstExpression = null;

    /** @var Node|string */
    public $secondExpression = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if ($this->secondExpression !== null) {
            return 'FROM_UNIXTIME('
                . $this->firstExpression->dispatch($sqlWalker)
                . ','
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'FROM_UNIXTIME(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->ArithmeticPrimary();

        // parse second parameter if available
        if ($lexer->lookahead->type === TokenType::T_COMMA) {
            $parser->match(TokenType::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}

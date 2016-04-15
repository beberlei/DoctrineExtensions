<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Performs an integer division. This is a MySQL operator, implemented as a Doctrine function.
 *
 * @see http://dev.mysql.com/doc/refman/en/arithmetic-functions.html#operator_div
 */
class Div extends FunctionNode
{
    /**
     * @var \Doctrine\ORM\Query\AST\Node
     */
    private $dividend;

    /**
     * @var \Doctrine\ORM\Query\AST\Node
     */
    private $divisor;

    /**
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return
            $sqlWalker->walkArithmeticPrimary($this->dividend) . ' DIV ' .
            $sqlWalker->walkArithmeticPrimary($this->divisor);
    }

    /**
     * @inheritdoc
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dividend = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->divisor = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

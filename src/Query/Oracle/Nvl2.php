<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/** @author https://github.com/nxtpge */
class Nvl2 extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $expr1;

    /** @var ArithmeticExpression */
    private $expr2;

    /** @var ArithmeticExpression */
    private $expr3;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'NVL2(%s, %s, %s)',
            $sqlWalker->walkArithmeticExpression($this->expr1),
            $sqlWalker->walkArithmeticExpression($this->expr2),
            $sqlWalker->walkArithmeticExpression($this->expr3)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr3 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}

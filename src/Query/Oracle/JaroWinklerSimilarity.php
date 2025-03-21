<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/** @author https://github.com/nxtpge */
class JaroWinklerSimilarity extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $expr1;

    /** @var ArithmeticExpression */
    private $expr2;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'UTL_MATCH.JARO_WINKLER_SIMILARITY(%s, %s)',
            $sqlWalker->walkArithmeticExpression($this->expr1),
            $sqlWalker->walkArithmeticExpression($this->expr2)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}

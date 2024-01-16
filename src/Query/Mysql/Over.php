<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function count;
use function trim;

class Over extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $arithmeticExpression;

    /** @var OrderByClause|null */
    private $orderByClause;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return isset($this->orderByClause) && count($this->orderByClause->orderByItems) > 0
            ? $sqlWalker->walkArithmeticExpression($this->arithmeticExpression) . ' OVER (' . trim($sqlWalker->walkOrderByClause($this->orderByClause)) . ')'
            : $sqlWalker->walkArithmeticExpression($this->arithmeticExpression) . ' OVER ()';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->arithmeticExpression = $parser->ArithmeticExpression();
        if (! $lexer->isNextToken(TokenType::T_CLOSE_PARENTHESIS)) {
            $parser->match(TokenType::T_COMMA);
            $this->orderByClause = $parser->OrderByClause();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}

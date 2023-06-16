<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\SimpleArithmeticExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class LastInsertId extends FunctionNode
{
    public SimpleArithmeticExpression $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker) : string
    {
        return isset($this->arithmeticExpression)
            ? sprintf('LAST_INSERT_ID(%s)', $sqlWalker->walkArithmeticPrimary($this->arithmeticExpression))
            : 'LAST_INSERT_ID()';
    }

    public function parse(Parser $parser) : void
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        if (!$lexer->isNextToken(Lexer::T_CLOSE_PARENTHESIS)) {
            $this->arithmeticExpression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

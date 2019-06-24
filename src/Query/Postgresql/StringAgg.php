<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Roberto Júnior <me@robertojunior.net>
 */
class StringAgg extends FunctionNode
{
    private $expression = null;

    private $delimiter = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expression = $parser->PathExpression(PathExpression::TYPE_STATE_FIELD);
        $parser->match(Lexer::T_COMMA);
        $this->delimiter = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'string_agg(%s, %s)',
            $sqlWalker->walkPathExpression($this->expression),
            $sqlWalker->walkStringPrimary($this->delimiter)
        );
    }
}

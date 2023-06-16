<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\ASTException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class Ilike extends FunctionNode
{
    /** @var Node */
    protected $field;

    /** @var Node */
    protected $query;

    /**
     * @param Parser $parser
     *
     * @throws QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->query = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     *
     * @throws ASTException
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return '(' . $this->field->dispatch($sqlWalker) . ' ILIKE ' . $this->query->dispatch($sqlWalker) . ')';
    }
}

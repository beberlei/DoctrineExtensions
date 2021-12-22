<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\ASTException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class ExtractFunction extends FunctionNode
{
    /** @var string */
    private $field;

    /** @var PathExpression */
    private $value;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @throws ASTException
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'EXTRACT(%s FROM %s)',
            $this->field,
            $this->value->dispatch($sqlWalker)
        );
    }

    /**
     * @param Parser $parser
     *
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $parser->match(Lexer::T_IDENTIFIER);
        $this->field = $parser->getLexer()->token['value'];

        $parser->match(Lexer::T_FROM);

        $this->value = $parser->ScalarExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

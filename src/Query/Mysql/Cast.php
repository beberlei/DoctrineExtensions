<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\AST\Node,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser,
    Doctrine\ORM\Query\QueryException,
    Doctrine\ORM\Query\SqlWalker;

/**
 * "CAST" "(" "$fieldIdentifierExpression" "AS" "$castingTypeExpression" ")"
 *
 * @example
 * SELECT CAST(foo.bar AS SIGNED) FROM dual;
 *
 * @link    https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/dql-user-defined-functions.html#conclusion
 * @link    https://dev.mysql.com/doc/refman/5.6/en/cast-functions.html#function_cast
 */
class Cast extends FunctionNode
{
    /** @var Node */
    protected $fieldIdentifierExpression;

    /** @var string */
    protected $castingTypeExpression;

    /**
     * @param Parser $parser
     *
     * @throws QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->fieldIdentifierExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_AS);
        $parser->match(Lexer::T_IDENTIFIER);

        $this->castingTypeExpression = $parser->getLexer()->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'CAST(%s AS %s)',
            $sqlWalker->walkSimpleArithmeticExpression($this->fieldIdentifierExpression),
            $this->castingTypeExpression
        );
    }
}
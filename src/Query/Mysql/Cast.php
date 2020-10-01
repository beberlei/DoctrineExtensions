<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "CAST" "(" "$fieldIdentifierExpression" "AS" "$castingTypeExpression" ")"
 *
 * @example SELECT CAST(foo.bar AS SIGNED) FROM dual;
 *
 * @link https://dev.mysql.com/doc/refman/en/cast-functions.html#function_cast
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

        $type = $parser->getLexer()->token['value'];

        if ($parser->getLexer()->isNextToken(Lexer::T_OPEN_PARENTHESIS)) {
            $parser->match(Lexer::T_OPEN_PARENTHESIS);
            /** @var Literal $parameter */
            $parameter = $parser->Literal();
            $parameters = [$parameter->value];

            if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
                while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
                    $parser->match(Lexer::T_COMMA);
                    $parameter = $parser->Literal();
                    $parameters[] = $parameter->value;
                }
            }

            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
            $type .= '('.implode(', ', $parameters).')';
        }

        $this->castingTypeExpression = $type;

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

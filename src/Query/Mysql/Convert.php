<?php


namespace DoctrineExtensions\Query\Mysql;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class Convert extends FunctionNode
{
    private $field;

    private $charset;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('CONVERT(%s, %s)',
            $sqlWalker->walkArithmeticPrimary($this->field),
            $sqlWalker->walkSimpleArithmeticExpression($this->charset)

        );
    }

    /**
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->field   = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->charset = $parser->AliasResultVariable();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

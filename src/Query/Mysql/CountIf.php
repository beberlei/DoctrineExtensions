<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;
use function strtolower;

/**
 * CountIfFunction ::= "COUNTIF" "(" ArithmeticExpression "," ArithmeticExpression [ "INVERSE" ] ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/counting-rows.html
 *
 * @author Andrew Mackrodt <andrew@ajmm.org>
 * @example SELECT COUNTIF(2, 3)
 * @example SELECT COUNTIF(2, 3 INVERSE)
 */
class CountIf extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $expr1;

    /** @var ArithmeticExpression */
    private $expr2;

    /** @var bool */
    private $inverse = false;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();

        $lexer = $parser->getLexer();

        while ($lexer->lookahead->type === TokenType::T_IDENTIFIER) {
            switch (strtolower($lexer->lookahead->value)) {
                case 'inverse':
                    $parser->match(TokenType::T_IDENTIFIER);
                    $this->inverse = true;

                    break;
                default: // Identifier not recognized (causes exception).
                    $parser->match(TokenType::T_CLOSE_PARENTHESIS);

                    break;
            }
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'COUNT(CASE %s WHEN %s THEN %s END)',
            $sqlWalker->walkArithmeticPrimary($this->expr1),
            $sqlWalker->walkArithmeticPrimary($this->expr2),
            ! $this->inverse ? '1 ELSE NULL' : 'NULL ELSE 1'
        );
    }
}

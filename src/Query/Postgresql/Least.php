<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function count;

/**
 * LeastFunction ::= "LEAST" "(" ArithmeticExpression {"," ArithmeticExpression}* ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-conditional.html#FUNCTIONS-GREATEST-LEAST
 *
 * @author Vas N <phpvas@gmail.com>
 * @author Leonardo B Motyczka <leomoty@gmail.com>
 *
 * @example SELECT LEAST(foo.bar, foo.bar2, foo.bar2) FROM entity
 */
class Least extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $field = null;

    /** @var array<ArithmeticExpression> */
    private $values = [];

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticExpression();
        $lexer       = $parser->getLexer();

        while (
            count($this->values) < 1 ||
            $lexer->lookahead->type !== TokenType::T_CLOSE_PARENTHESIS
        ) {
            $parser->match(TokenType::T_COMMA);
            $this->values[] = $parser->ArithmeticExpression();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $query = 'LEAST(';

        $query .= $this->field->dispatch($sqlWalker);

        $query .= ', ';

        for ($i = 0; $i < count($this->values); $i++) {
            if ($i > 0) {
                $query .= ', ';
            }

            $query .= $this->values[$i]->dispatch($sqlWalker);
        }

        $query .= ')';

        return $query;
    }
}

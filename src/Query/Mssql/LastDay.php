<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
class LastDay extends FunctionNode
{
    public $date;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATEPART(DATE, DATEADD(SECOND, -1, DATEADD(MONTH, DATEDIFF(MONTH, 0, ' . $sqlWalker->walkArithmeticPrimary($this->date) . ') + 1, 0)))';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

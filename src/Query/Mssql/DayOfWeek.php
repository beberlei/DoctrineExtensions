<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class DayOfWeek extends FunctionNode
{
    public $date;
    
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATEPART(WEEKDAY, ' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }
    
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        
        $this->date = $parser->ArithmeticPrimary();
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

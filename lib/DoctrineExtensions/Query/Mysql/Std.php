<?php
/**
 * DoctrineExtensions Mysql Function Pack
 * MySql STD function: http://dev.mysql.com/doc/refman/5.0/en/group-by-functions.html#function_std
 */
namespace Application\DoctrineExtensions\Query\Mysql;
use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;
class Std extends FunctionNode
{
    public $arithmeticExpression;
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'STD(' . $sqlWalker->walkSimpleArithmeticExpression(
                $this->arithmeticExpression
        ) . ')';
    }
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
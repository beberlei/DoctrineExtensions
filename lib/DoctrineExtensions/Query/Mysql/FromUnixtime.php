<?php
namespace DoctrineExtensions\Query\Mysql;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

class FromUnixtime extends FunctionNode{

    public $date;

        /**     * @override     */

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)    {

                    return "FROM_UNIXTIME(" . $sqlWalker->walkArithmeticPrimary($this->date) . ")";

    }
                            /**     * @override     */

    public function parse(\Doctrine\ORM\Query\Parser $parser)    {

                    $parser->match(Lexer::T_IDENTIFIER);
                    $parser->match(Lexer::T_OPEN_PARENTHESIS);
                    $this->date = $parser->ArithmeticPrimary();
                    $parser->match(Lexer::T_CLOSE_PARENTHESIS);

    }

}

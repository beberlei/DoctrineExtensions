<?php

/**
 * DoctrineExtensions Oracle Function Pack
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Usage: NVL(expr1, expr2)
 * 
 * NVL lets you replace null (returned as a blank) with a string in the results of a query. 
 * If expr1 is null, then NVL returns expr2. If expr1 is not null, then NVL returns expr1.
 * 
 * @author  Andréia Bohner <andreiabohner@gmail.com>
 */
class Nvl extends FunctionNode
{
    private $expr1;
    private $expr2;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
                'NVL(%s, %s)',
                $sqlWalker->walkArithmeticPrimary($this->expr1),
                $sqlWalker->walkArithmeticPrimary($this->expr2));
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}

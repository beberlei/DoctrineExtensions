<?php

/**
 * DoctrineExtensions Mysql Function Pack
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

class Atan2 extends FunctionNode
{

    public $firstExpression;
    public $secondExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {

        $firstArgument = $sqlWalker->walkSimpleArithmeticExpression(
                        $this->firstExpression
        );

        $secondArgument = $sqlWalker->walkSimpleArithmeticExpression(
                        $this->secondExpression
        );

        return 'ATAN2(' . $firstArgument . ', ' . $secondArgument . ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_COMMA);

        $this->secondExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}
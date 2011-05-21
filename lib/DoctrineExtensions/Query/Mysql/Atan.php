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
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\QueryException;

class Atan extends FunctionNode
{

    public $arithmeticExpression;
    public $optionalSecondExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {

        $secondArgument = '';

        if ($this->optionalSecondExpression) {

            $secondArgument = $sqlWalker->walkSimpleArithmeticExpression(
                            $this->optionalSecondExpression
            );
        }

        return 'ATAN(' . $sqlWalker->walkSimpleArithmeticExpression(
                $this->arithmeticExpression
        ) . (($secondArgument) ? ', ' . $secondArgument : '')
        . ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        try {

            $parser->match(Lexer::T_COMMA);

            $this->optionalSecondExpression = $parser->SimpleArithmeticExpression();

            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        } catch (QueryException $e) {

            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        }
    }

}
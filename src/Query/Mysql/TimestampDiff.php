<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Przemek Sobstel <przemek@sobstel.org>
 */
class TimestampDiff extends FunctionNode
{
    public $firstDatetimeExpression = null;

    public $secondDatetimeExpression = null;

    public $unit = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_IDENTIFIER);
        $lexer = $parser->getLexer();
        $this->unit = $lexer->token['value'];
        $parser->match(Lexer::T_COMMA);
        $this->firstDatetimeExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondDatetimeExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sql_walker)
    {
        return sprintf(
          'TIMESTAMPDIFF(%s, %s, %s)',
          $this->unit,
          $this->firstDatetimeExpression->dispatch($sql_walker),
          $this->secondDatetimeExpression->dispatch($sql_walker)
      );
    }
}

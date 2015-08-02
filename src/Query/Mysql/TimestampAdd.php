<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Alessandro Tagliapietra <tagliapietra.alessandro@gmail.com>
 */
class TimestampAdd extends FunctionNode
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
      return sprintf('TIMESTAMPADD(%s, %s, %s)',
          $this->unit,
          $this->firstDatetimeExpression->dispatch($sql_walker),
          $this->secondDatetimeExpression->dispatch($sql_walker)
      );
  }
}

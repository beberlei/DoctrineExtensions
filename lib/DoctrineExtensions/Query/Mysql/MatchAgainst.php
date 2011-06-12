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

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * MatchAgainstFunction ::=
 *  "MATCH" "(" StateFieldPathExpression {"," StateFieldPathExpression}* ")" "AGAINST" "("
 *      StringPrimary ["BOOLEAN"] ["EXPAND"] ")"
 */
class MatchAgainst extends FunctionNode {

  /** @var array list of \Doctrine\ORM\Query\AST\PathExpression */
  protected $pathExp = null;

  /** @var string */
  protected $against = null;

  /** @var boolean */
  protected $booleanMode = false;

  /** @var boolean */
  protected $queryExpansion = false;

  public function parse(Parser $parser) {
    // match
    $parser->match(Lexer::T_IDENTIFIER);
    $parser->match(Lexer::T_OPEN_PARENTHESIS);

    // first Path Expression is mandatory
    $this->pathExp = array();
    $this->pathExp[] = $parser->StateFieldPathExpression();

    // Subsequent Path Expressions are optional
    $lexer = $parser->getLexer();
    while ($lexer->isNextToken(Lexer::T_COMMA)) { 
      $parser->match(Lexer::T_COMMA); 
      $this->pathExp[] = $parser->StateFieldPathExpression(); 
    }

    $parser->match(Lexer::T_CLOSE_PARENTHESIS);

    // against
    if (strtolower($lexer->lookahead['value']) !== 'against') {
      $parser->syntaxError('against');
    }

    $parser->match(Lexer::T_IDENTIFIER);
    $parser->match(Lexer::T_OPEN_PARENTHESIS);
    $this->against = $parser->StringPrimary();

    if (strtolower($lexer->lookahead['value']) === 'boolean') {
      $parser->match(Lexer::T_IDENTIFIER);
      $this->booleanMode = true;
    }

    if (strtolower($lexer->lookahead['value']) === 'expand') {
      $parser->match(Lexer::T_IDENTIFIER);
      $this->queryExpansion = true;
    }

    $parser->match(Lexer::T_CLOSE_PARENTHESIS);
  }

  public function getSql(SqlWalker $walker) {
    $fields = array();
    foreach ($this->pathExp as $pathExp) {
      $fields[] = $pathExp->dispatch($walker);
    }

    $against = $walker->walkStringPrimary($this->against)
        . ($this->booleanMode ? ' IN BOOLEAN MODE' : '')
        . ($this->queryExpansion ? ' WITH QUERY EXPANSION' : '');

    return sprintf('MATCH (%s) AGAINST (%s)', implode(', ', $fields), $against);
  }
}

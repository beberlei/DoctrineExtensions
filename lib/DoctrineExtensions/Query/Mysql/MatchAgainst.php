<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

class MatchAgainst extends FunctionNode {

  /** @var array list of \Doctrine\ORM\Query\AST\PathExpression */
  protected $pathExp = null;

  /** @var string */
  protected $against = null;

  /** @var boolean */
  protected $booleanMode = false;

  /** @var boolean */
  protected $queryExpansion = false;

  public function parse(\Doctrine\ORM\Query\Parser $parser) {
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

  public function getSql(\Doctrine\ORM\Query\SqlWalker $walker) {
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

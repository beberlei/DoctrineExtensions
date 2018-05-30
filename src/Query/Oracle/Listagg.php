<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Alexey Kalinin <nitso@yandex.ru>
 */
class Listagg extends FunctionNode
{
    /**
     * @var Node
     */
    public $separator = null;

    /**
     * @var Node
     */
    public $listaggField = null;

    /**
     * @var OrderByClause
     */
    public $orderBy;

    /**
     * @var Node[]
     */
    public $partitionBy = [];

    /**
     * @inheritdoc
     */
    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->listaggField = $parser->StringPrimary();

        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->separator = $parser->StringExpression();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

        if (!$lexer->isNextToken(Lexer::T_IDENTIFIER) || strtolower($lexer->lookahead['value']) != 'within') {
            $parser->syntaxError('WITHIN GROUP');
        }
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_GROUP);

        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->orderBy = $parser->OrderByClause();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

        if ($lexer->isNextToken(Lexer::T_IDENTIFIER)) {
            if (strtolower($lexer->lookahead['value']) != 'over') {
                $parser->syntaxError('OVER');
            }
            $parser->match(Lexer::T_IDENTIFIER);
            $parser->match(Lexer::T_OPEN_PARENTHESIS);

            if (!$lexer->isNextToken(Lexer::T_IDENTIFIER) || strtolower($lexer->lookahead['value']) != 'partition') {
                $parser->syntaxError('PARTITION BY');
            }
            $parser->match(Lexer::T_IDENTIFIER);
            $parser->match(Lexer::T_BY);

            $this->partitionBy[] = $parser->StringPrimary();

            while ($lexer->isNextToken(Lexer::T_COMMA)) {
                $parser->match(Lexer::T_COMMA);
                $this->partitionBy[] = $parser->StringPrimary();
            }

            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        }
    }

    /**
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $result = 'LISTAGG(' . $this->listaggField->dispatch($sqlWalker);
        if ($this->separator) {
            $result .= ', ' . $sqlWalker->walkStringPrimary($this->separator) . ')';
        } else {
            $result .= ')';
        }

        $result .= ' WITHIN GROUP (' . $sqlWalker->walkOrderByClause($this->orderBy) . ')';

        if (count($this->partitionBy)) {
            $partitionBy = [];
            foreach ($this->partitionBy as $part) {
                $partitionBy[] = $part->dispatch($sqlWalker);
            }

            $result .= ' PARTITION BY (' . implode($partitionBy, ',') . ')';
        }

        return $result;
    }
}

<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * AesDecryptFunction ::= "AES_DECRYPT" "(" StringExpression "," StringExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/encryption-functions.html#function_aes-decrypt
 *
 * @example SELECT AES_DECRYPT(foo.crypt, foo.key) FROM entity
 */
class AesDecrypt extends FunctionNode
{
    /** @var Node|Subselect|string */
    public $field = '';

    /** @var Node|Subselect|string */
    public $key = '';

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringExpression();
        $parser->match(TokenType::T_COMMA);
        $this->key = $parser->StringExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'AES_DECRYPT(%s, %s)',
            $this->field->dispatch($sqlWalker),
            $this->key->dispatch($sqlWalker)
        );
    }
}

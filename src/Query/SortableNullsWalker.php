<?php

namespace DoctrineExtensions\Query;

use Doctrine\ORM\Query;

/**
 * The SortableNullsWalker is a TreeWalker that walks over a DQL AST and constructs
 * the corresponding SQL to allow ORDER BY x ASC NULLS FIRST|LAST.
 *
 * $qb = $em->createQueryBuilder()
 *     ->select('p')
 *     ->from('Webges\Domain\Core\Person\Person', 'p')
 *     ->where('p.id = 1')
 *     ->orderBy('p.firstname', 'ASC')
 *     ->addOrderBy('p.lastname', 'DESC')
 *     ->addOrderBy('p.id', 'DESC'); // relation to person
 *
 * $query = $qb->getQuery();
 * $query->setHint(Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 'Webges\DoctrineExtensions\Query\SortableNullsWalker');
 * $query->setHint("sortableNulls.fields", array(
 *     "p.firstname" => Webges\DoctrineExtensions\Query\SortableNullsWalker::NULLS_FIRST,
 *     "p.lastname"  => Webges\DoctrineExtensions\Query\SortableNullsWalker::NULLS_LAST,
 *     "p.id" => Webges\DoctrineExtensions\Query\SortableNullsWalker::NULLS_LAST
 * ));
 *
 * @see http://www.doctrine-project.org/jira/browse/DDC-490
 */
class SortableNullsWalker extends Query\SqlWalker
{
    const NULLS_FIRST = 'NULLS FIRST';
    const NULLS_LAST = 'NULLS LAST';

    public function walkOrderByItem($orderByItem)
    {
        $sql = parent::walkOrderByItem($orderByItem);
        $hint = $this->getQuery()->getHint('sortableNulls.fields');
        $expr = $orderByItem->expression;
        $type = strtoupper($orderByItem->type);

        if (is_array($hint) && count($hint)) {
            // check for a state field
            if (
                    $expr instanceof Query\AST\PathExpression &&
                    $expr->type == Query\AST\PathExpression::TYPE_STATE_FIELD
            ) {
                $fieldName = $expr->field;
                $dqlAlias = $expr->identificationVariable;
                $search = $this->walkPathExpression($expr) . ' ' . $type;
                $index = $dqlAlias . '.' . $fieldName;
                $sql = str_replace($search, $search . ' ' . $hint[$index], $sql);
            }
        }

        return $sql;
    }
}

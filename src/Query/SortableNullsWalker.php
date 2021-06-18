<?php

namespace DoctrineExtensions\Query;

use Doctrine\ORM\Query;

/**
 * The SortableNullsWalker is a TreeWalker that walks over a DQL AST and constructs
 * the corresponding SQL to allow ORDER BY x ASC NULLS FIRST|LAST.
 *
 * use \DoctrineExtensions\Query\SortableNullsWalker;
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
 * $query->setHint(Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, SortableNullsWalker::class);
 * $query->setHint(SortableNullsWalker::HINT, array(
 *     "p.firstname" => SortableNullsWalker::NULLS_FIRST,
 *     "p.lastname"  => SortableNullsWalker::NULLS_LAST,
 *     "p.id" => SortableNullsWalker::NULLS_LAST
 * ));
 *
 * @see http://www.doctrine-project.org/jira/browse/DDC-490
 */
class SortableNullsWalker extends Query\SqlWalker
{
    const NULLS_FIRST = 'NULLS FIRST';

    const NULLS_LAST = 'NULLS LAST';

    const HINT = 'sortableNulls.fields';

    public function walkOrderByItem($orderByItem)
    {
        $sql = parent::walkOrderByItem($orderByItem);
        $hint = $this->getQuery()->getHint(self::HINT);
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
                if (isset($hint[$index])) {
                    $sql = str_replace($search, $search . ' ' . $hint[$index], $sql);
                }
            }
        }

        return $sql;
    }
}

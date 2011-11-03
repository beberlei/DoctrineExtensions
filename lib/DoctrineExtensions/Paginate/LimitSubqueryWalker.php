<?php

/**
 * DoctrineExtensions Paginate
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Paginate
 * @author      Sander Marechal <s.marechal@jejik.com>
 * @copyright   Copyright (c) 2011 Sander Marechal
 * @license     http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace DoctrineExtensions\Paginate;

use Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\AST;

/**
 * Wrap the query in order to select root entity IDs for pagination
 *
 * Given a DQL like `SELECT u FROM User u` it will generate an SQL query like:
 * SELECT DISTINCT <id> FROM (<original SQL>) LIMIT x OFFSET y
 *
 * Works with composite keys but cannot deal with queries that have multiple
 * root entities (e.g. `SELECT f, b from Foo, Bar`)
 */
class LimitSubqueryWalker extends SqlWalker
{
    /**
     * @var Doctrine\DBAL\Platforms\AbstractPlatform
     */
    private $platform;

    /**
     * @var Doctrine\ORM\Query\ResultSetMapping
     */
    private $rsm;

    /**
     * @var array
     */
    private $queryComponents;

    /**
     * @var int
     */
    private $firstResult;

    /**
     * @var int
     */
    private $maxResults;

    /**
     * Constructor. Stores various parameters that are otherwise unavailable
     * because Doctrine\ORM\Query\SqlWalker keeps everything private without
     * accessors.
     *
     * @param Doctrine\ORM\Query $query
     * @param Doctrine\ORM\Query\ParserResult $parserResult
     * @param array $queryComponents
     */
    public function __construct($query, $parserResult, array $queryComponents)
    {
        $this->platform = $query->getEntityManager()->getConnection()->getDatabasePlatform();
        $this->rsm = $parserResult->getResultSetMapping();
        $this->queryComponents = $queryComponents;

        // Reset limit and offset
        $this->firstResult = $query->getFirstResult();
        $this->maxResults = $query->getMaxResults();
        $query->setFirstResult(null)->setMaxResults(null);

        parent::__construct($query, $parserResult, $queryComponents);
    }

    /**
     * Walks down a SelectStatement AST node, wrapping it in a SELECT DISTINCT
     *
     * @param SelectStatement $AST
     * @return string
     */
    public function walkSelectStatement(AST\SelectStatement $AST)
    {
        $sql = parent::walkSelectStatement($AST);

        // Find out the SQL alias of the identifier column of the root entity
        // It may be possible to make this work with multiple root entities but that
        // would probably require issuing multiple queries or doing a UNION SELECT
        // so for now, It's not supported.

        // Get the root entity and alias from the AST fromClause
        $from = $AST->fromClause->identificationVariableDeclarations;
        if (count($from) !== 1) {
            throw new \Exception('Cannot generate limit for DQL query with multiple root entities');
        }

        $rootClass = $from[0]->rangeVariableDeclaration->abstractSchemaName;
        $rootAlias = $from[0]->rangeVariableDeclaration->aliasIdentificationVariable;

        // Get the identity properties from the metadata
        $metadata = $this->queryComponents[$rootAlias]['metadata'];
        $rootIdentifier = $metadata->identifier;

        // For every identifier, find out the SQL alias by combing through the ResultSetMapping
        $sqlIdentifier = array();
        foreach ($rootIdentifier as $property) {
            foreach (array_keys($this->rsm->fieldMappings, $property) as $alias) {
                if ($this->rsm->columnOwnerMap[$alias] == $rootAlias) {
                    $sqlIdentifier[$property] = $alias;
                }
            }
        }

        if (count($rootIdentifier) != count($sqlIdentifier)) {
            throw new \Exception(sprintf(
                'Not all identifier properties can be found in the ResultSetMapping: %s',
                implode(', ', array_diff($rootIdentifier, array_keys($sqlIdentifier)))
            ));
        }

        // Build the counter query
        $sql = sprintf('SELECT DISTINCT %s FROM (%s) AS _dctrn_result',
            implode(', ', $sqlIdentifier), $sql);

        // Apply the limit and offset
        $sql = $this->platform->modifyLimitQuery(
            $sql, $this->maxResults, $this->firstResult
        );

        // Add the columns to the ResultSetMapping. It's not really nice but
        // it works. Preferably I'd clear the RSM or simply create a new one
        // but that is not possible from inside the output walker, so we dirty
        // up the one we have.
        foreach ($sqlIdentifier as $property => $alias) {
            $this->rsm->addScalarResult($alias, $property);
        }

        return $sql;
    }
}

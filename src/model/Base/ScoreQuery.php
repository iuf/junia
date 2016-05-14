<?php

namespace iuf\junia\model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use iuf\junia\model\Score as ChildScore;
use iuf\junia\model\ScoreQuery as ChildScoreQuery;
use iuf\junia\model\Map\ScoreTableMap;

/**
 * Base class that represents a query for the 'kk_junia_score' table.
 *
 *
 *
 * @method     ChildScoreQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildScoreQuery orderByRoutineId($order = Criteria::ASC) Order by the routine_id column
 * @method     ChildScoreQuery orderByJudgeId($order = Criteria::ASC) Order by the judge_id column
 * @method     ChildScoreQuery orderByTotal($order = Criteria::ASC) Order by the total column
 * @method     ChildScoreQuery orderByDescendantClass($order = Criteria::ASC) Order by the descendant_class column
 *
 * @method     ChildScoreQuery groupById() Group by the id column
 * @method     ChildScoreQuery groupByRoutineId() Group by the routine_id column
 * @method     ChildScoreQuery groupByJudgeId() Group by the judge_id column
 * @method     ChildScoreQuery groupByTotal() Group by the total column
 * @method     ChildScoreQuery groupByDescendantClass() Group by the descendant_class column
 *
 * @method     ChildScoreQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildScoreQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildScoreQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildScoreQuery leftJoinRoutine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Routine relation
 * @method     ChildScoreQuery rightJoinRoutine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Routine relation
 * @method     ChildScoreQuery innerJoinRoutine($relationAlias = null) Adds a INNER JOIN clause to the query using the Routine relation
 *
 * @method     ChildScoreQuery leftJoinJudge($relationAlias = null) Adds a LEFT JOIN clause to the query using the Judge relation
 * @method     ChildScoreQuery rightJoinJudge($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Judge relation
 * @method     ChildScoreQuery innerJoinJudge($relationAlias = null) Adds a INNER JOIN clause to the query using the Judge relation
 *
 * @method     ChildScoreQuery leftJoinPerformanceScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildScoreQuery rightJoinPerformanceScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildScoreQuery innerJoinPerformanceScore($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceScore relation
 *
 * @method     \iuf\junia\model\RoutineQuery|\iuf\junia\model\JudgeQuery|\iuf\junia\model\PerformanceScoreQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildScore findOne(ConnectionInterface $con = null) Return the first ChildScore matching the query
 * @method     ChildScore findOneOrCreate(ConnectionInterface $con = null) Return the first ChildScore matching the query, or a new ChildScore object populated from the query conditions when no match is found
 *
 * @method     ChildScore findOneById(int $id) Return the first ChildScore filtered by the id column
 * @method     ChildScore findOneByRoutineId(int $routine_id) Return the first ChildScore filtered by the routine_id column
 * @method     ChildScore findOneByJudgeId(int $judge_id) Return the first ChildScore filtered by the judge_id column
 * @method     ChildScore findOneByTotal(double $total) Return the first ChildScore filtered by the total column
 * @method     ChildScore findOneByDescendantClass(string $descendant_class) Return the first ChildScore filtered by the descendant_class column *

 * @method     ChildScore requirePk($key, ConnectionInterface $con = null) Return the ChildScore by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScore requireOne(ConnectionInterface $con = null) Return the first ChildScore matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScore requireOneById(int $id) Return the first ChildScore filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScore requireOneByRoutineId(int $routine_id) Return the first ChildScore filtered by the routine_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScore requireOneByJudgeId(int $judge_id) Return the first ChildScore filtered by the judge_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScore requireOneByTotal(double $total) Return the first ChildScore filtered by the total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildScore requireOneByDescendantClass(string $descendant_class) Return the first ChildScore filtered by the descendant_class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildScore[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildScore objects based on current ModelCriteria
 * @method     ChildScore[]|ObjectCollection findById(int $id) Return ChildScore objects filtered by the id column
 * @method     ChildScore[]|ObjectCollection findByRoutineId(int $routine_id) Return ChildScore objects filtered by the routine_id column
 * @method     ChildScore[]|ObjectCollection findByJudgeId(int $judge_id) Return ChildScore objects filtered by the judge_id column
 * @method     ChildScore[]|ObjectCollection findByTotal(double $total) Return ChildScore objects filtered by the total column
 * @method     ChildScore[]|ObjectCollection findByDescendantClass(string $descendant_class) Return ChildScore objects filtered by the descendant_class column
 * @method     ChildScore[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ScoreQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\ScoreQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\Score', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildScoreQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildScoreQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildScoreQuery) {
            return $criteria;
        }
        $query = new ChildScoreQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildScore|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScoreTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ScoreTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildScore A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `routine_id`, `judge_id`, `total`, `descendant_class` FROM `kk_junia_score` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildScore $obj */
            $obj = new ChildScore();
            $obj->hydrate($row);
            ScoreTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildScore|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ScoreTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ScoreTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ScoreTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ScoreTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the routine_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoutineId(1234); // WHERE routine_id = 1234
     * $query->filterByRoutineId(array(12, 34)); // WHERE routine_id IN (12, 34)
     * $query->filterByRoutineId(array('min' => 12)); // WHERE routine_id > 12
     * </code>
     *
     * @see       filterByRoutine()
     *
     * @param     mixed $routineId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByRoutineId($routineId = null, $comparison = null)
    {
        if (is_array($routineId)) {
            $useMinMax = false;
            if (isset($routineId['min'])) {
                $this->addUsingAlias(ScoreTableMap::COL_ROUTINE_ID, $routineId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($routineId['max'])) {
                $this->addUsingAlias(ScoreTableMap::COL_ROUTINE_ID, $routineId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreTableMap::COL_ROUTINE_ID, $routineId, $comparison);
    }

    /**
     * Filter the query on the judge_id column
     *
     * Example usage:
     * <code>
     * $query->filterByJudgeId(1234); // WHERE judge_id = 1234
     * $query->filterByJudgeId(array(12, 34)); // WHERE judge_id IN (12, 34)
     * $query->filterByJudgeId(array('min' => 12)); // WHERE judge_id > 12
     * </code>
     *
     * @see       filterByJudge()
     *
     * @param     mixed $judgeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByJudgeId($judgeId = null, $comparison = null)
    {
        if (is_array($judgeId)) {
            $useMinMax = false;
            if (isset($judgeId['min'])) {
                $this->addUsingAlias(ScoreTableMap::COL_JUDGE_ID, $judgeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($judgeId['max'])) {
                $this->addUsingAlias(ScoreTableMap::COL_JUDGE_ID, $judgeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreTableMap::COL_JUDGE_ID, $judgeId, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(ScoreTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(ScoreTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScoreTableMap::COL_TOTAL, $total, $comparison);
    }

    /**
     * Filter the query on the descendant_class column
     *
     * Example usage:
     * <code>
     * $query->filterByDescendantClass('fooValue');   // WHERE descendant_class = 'fooValue'
     * $query->filterByDescendantClass('%fooValue%'); // WHERE descendant_class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descendantClass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function filterByDescendantClass($descendantClass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descendantClass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descendantClass)) {
                $descendantClass = str_replace('*', '%', $descendantClass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ScoreTableMap::COL_DESCENDANT_CLASS, $descendantClass, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildScoreQuery The current query, for fluid interface
     */
    public function filterByRoutine($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(ScoreTableMap::COL_ROUTINE_ID, $routine->getId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ScoreTableMap::COL_ROUTINE_ID, $routine->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRoutine() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Routine relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function joinRoutine($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Routine');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Routine');
        }

        return $this;
    }

    /**
     * Use the Routine relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutine($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Routine', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Judge object
     *
     * @param \iuf\junia\model\Judge|ObjectCollection $judge The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildScoreQuery The current query, for fluid interface
     */
    public function filterByJudge($judge, $comparison = null)
    {
        if ($judge instanceof \iuf\junia\model\Judge) {
            return $this
                ->addUsingAlias(ScoreTableMap::COL_JUDGE_ID, $judge->getId(), $comparison);
        } elseif ($judge instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ScoreTableMap::COL_JUDGE_ID, $judge->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJudge() only accepts arguments of type \iuf\junia\model\Judge or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Judge relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function joinJudge($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Judge');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Judge');
        }

        return $this;
    }

    /**
     * Use the Judge relation Judge object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\JudgeQuery A secondary query class using the current class as primary query
     */
    public function useJudgeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJudge($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Judge', '\iuf\junia\model\JudgeQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceScore object
     *
     * @param \iuf\junia\model\PerformanceScore|ObjectCollection $performanceScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildScoreQuery The current query, for fluid interface
     */
    public function filterByPerformanceScore($performanceScore, $comparison = null)
    {
        if ($performanceScore instanceof \iuf\junia\model\PerformanceScore) {
            return $this
                ->addUsingAlias(ScoreTableMap::COL_ID, $performanceScore->getId(), $comparison);
        } elseif ($performanceScore instanceof ObjectCollection) {
            return $this
                ->usePerformanceScoreQuery()
                ->filterByPrimaryKeys($performanceScore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPerformanceScore() only accepts arguments of type \iuf\junia\model\PerformanceScore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PerformanceScore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function joinPerformanceScore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PerformanceScore');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PerformanceScore');
        }

        return $this;
    }

    /**
     * Use the PerformanceScore relation PerformanceScore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\PerformanceScoreQuery A secondary query class using the current class as primary query
     */
    public function usePerformanceScoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPerformanceScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceScore', '\iuf\junia\model\PerformanceScoreQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildScore $score Object to remove from the list of results
     *
     * @return $this|ChildScoreQuery The current query, for fluid interface
     */
    public function prune($score = null)
    {
        if ($score) {
            $this->addUsingAlias(ScoreTableMap::COL_ID, $score->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_score table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ScoreTableMap::clearInstancePool();
            ScoreTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ScoreTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ScoreTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ScoreTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ScoreQuery

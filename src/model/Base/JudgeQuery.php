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
use iuf\junia\model\Judge as ChildJudge;
use iuf\junia\model\JudgeQuery as ChildJudgeQuery;
use iuf\junia\model\Map\JudgeTableMap;
use keeko\core\model\User;

/**
 * Base class that represents a query for the 'kk_junia_judge' table.
 *
 *
 *
 * @method     ChildJudgeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJudgeQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildJudgeQuery orderByStartgroupId($order = Criteria::ASC) Order by the startgroup_id column
 * @method     ChildJudgeQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 *
 * @method     ChildJudgeQuery groupById() Group by the id column
 * @method     ChildJudgeQuery groupByPosition() Group by the position column
 * @method     ChildJudgeQuery groupByStartgroupId() Group by the startgroup_id column
 * @method     ChildJudgeQuery groupByUserId() Group by the user_id column
 *
 * @method     ChildJudgeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJudgeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJudgeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJudgeQuery leftJoinStartgroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Startgroup relation
 * @method     ChildJudgeQuery rightJoinStartgroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Startgroup relation
 * @method     ChildJudgeQuery innerJoinStartgroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Startgroup relation
 *
 * @method     ChildJudgeQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildJudgeQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildJudgeQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildJudgeQuery leftJoinScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Score relation
 * @method     ChildJudgeQuery rightJoinScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Score relation
 * @method     ChildJudgeQuery innerJoinScore($relationAlias = null) Adds a INNER JOIN clause to the query using the Score relation
 *
 * @method     ChildJudgeQuery leftJoinPerformanceScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildJudgeQuery rightJoinPerformanceScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildJudgeQuery innerJoinPerformanceScore($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceScore relation
 *
 * @method     \iuf\junia\model\StartgroupQuery|\keeko\core\model\UserQuery|\iuf\junia\model\ScoreQuery|\iuf\junia\model\PerformanceScoreQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJudge findOne(ConnectionInterface $con = null) Return the first ChildJudge matching the query
 * @method     ChildJudge findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJudge matching the query, or a new ChildJudge object populated from the query conditions when no match is found
 *
 * @method     ChildJudge findOneById(int $id) Return the first ChildJudge filtered by the id column
 * @method     ChildJudge findOneByPosition(string $position) Return the first ChildJudge filtered by the position column
 * @method     ChildJudge findOneByStartgroupId(int $startgroup_id) Return the first ChildJudge filtered by the startgroup_id column
 * @method     ChildJudge findOneByUserId(int $user_id) Return the first ChildJudge filtered by the user_id column *

 * @method     ChildJudge requirePk($key, ConnectionInterface $con = null) Return the ChildJudge by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJudge requireOne(ConnectionInterface $con = null) Return the first ChildJudge matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJudge requireOneById(int $id) Return the first ChildJudge filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJudge requireOneByPosition(string $position) Return the first ChildJudge filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJudge requireOneByStartgroupId(int $startgroup_id) Return the first ChildJudge filtered by the startgroup_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJudge requireOneByUserId(int $user_id) Return the first ChildJudge filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJudge[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJudge objects based on current ModelCriteria
 * @method     ChildJudge[]|ObjectCollection findById(int $id) Return ChildJudge objects filtered by the id column
 * @method     ChildJudge[]|ObjectCollection findByPosition(string $position) Return ChildJudge objects filtered by the position column
 * @method     ChildJudge[]|ObjectCollection findByStartgroupId(int $startgroup_id) Return ChildJudge objects filtered by the startgroup_id column
 * @method     ChildJudge[]|ObjectCollection findByUserId(int $user_id) Return ChildJudge objects filtered by the user_id column
 * @method     ChildJudge[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JudgeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\JudgeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\Judge', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJudgeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJudgeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJudgeQuery) {
            return $criteria;
        }
        $query = new ChildJudgeQuery();
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
     * @return ChildJudge|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JudgeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JudgeTableMap::DATABASE_NAME);
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
     * @return ChildJudge A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `position`, `startgroup_id`, `user_id` FROM `kk_junia_judge` WHERE `id` = :p0';
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
            /** @var ChildJudge $obj */
            $obj = new ChildJudge();
            $obj->hydrate($row);
            JudgeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildJudge|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JudgeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JudgeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JudgeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JudgeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JudgeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition('fooValue');   // WHERE position = 'fooValue'
     * $query->filterByPosition('%fooValue%'); // WHERE position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $position The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($position)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $position)) {
                $position = str_replace('*', '%', $position);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JudgeTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the startgroup_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStartgroupId(1234); // WHERE startgroup_id = 1234
     * $query->filterByStartgroupId(array(12, 34)); // WHERE startgroup_id IN (12, 34)
     * $query->filterByStartgroupId(array('min' => 12)); // WHERE startgroup_id > 12
     * </code>
     *
     * @see       filterByStartgroup()
     *
     * @param     mixed $startgroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByStartgroupId($startgroupId = null, $comparison = null)
    {
        if (is_array($startgroupId)) {
            $useMinMax = false;
            if (isset($startgroupId['min'])) {
                $this->addUsingAlias(JudgeTableMap::COL_STARTGROUP_ID, $startgroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startgroupId['max'])) {
                $this->addUsingAlias(JudgeTableMap::COL_STARTGROUP_ID, $startgroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JudgeTableMap::COL_STARTGROUP_ID, $startgroupId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(JudgeTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(JudgeTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JudgeTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByStartgroup($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(JudgeTableMap::COL_STARTGROUP_ID, $startgroup->getId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JudgeTableMap::COL_STARTGROUP_ID, $startgroup->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStartgroup() only accepts arguments of type \iuf\junia\model\Startgroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Startgroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function joinStartgroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Startgroup');

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
            $this->addJoinObject($join, 'Startgroup');
        }

        return $this;
    }

    /**
     * Use the Startgroup relation Startgroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\StartgroupQuery A secondary query class using the current class as primary query
     */
    public function useStartgroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStartgroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Startgroup', '\iuf\junia\model\StartgroupQuery');
    }

    /**
     * Filter the query by a related \keeko\core\model\User object
     *
     * @param \keeko\core\model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \keeko\core\model\User) {
            return $this
                ->addUsingAlias(JudgeTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JudgeTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \keeko\core\model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \keeko\core\model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\keeko\core\model\UserQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Score object
     *
     * @param \iuf\junia\model\Score|ObjectCollection $score the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByScore($score, $comparison = null)
    {
        if ($score instanceof \iuf\junia\model\Score) {
            return $this
                ->addUsingAlias(JudgeTableMap::COL_ID, $score->getJudgeId(), $comparison);
        } elseif ($score instanceof ObjectCollection) {
            return $this
                ->useScoreQuery()
                ->filterByPrimaryKeys($score->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByScore() only accepts arguments of type \iuf\junia\model\Score or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Score relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function joinScore($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Score');

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
            $this->addJoinObject($join, 'Score');
        }

        return $this;
    }

    /**
     * Use the Score relation Score object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\ScoreQuery A secondary query class using the current class as primary query
     */
    public function useScoreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Score', '\iuf\junia\model\ScoreQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceScore object
     *
     * @param \iuf\junia\model\PerformanceScore|ObjectCollection $performanceScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJudgeQuery The current query, for fluid interface
     */
    public function filterByPerformanceScore($performanceScore, $comparison = null)
    {
        if ($performanceScore instanceof \iuf\junia\model\PerformanceScore) {
            return $this
                ->addUsingAlias(JudgeTableMap::COL_ID, $performanceScore->getJudgeId(), $comparison);
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
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function joinPerformanceScore($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function usePerformanceScoreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerformanceScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceScore', '\iuf\junia\model\PerformanceScoreQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJudge $judge Object to remove from the list of results
     *
     * @return $this|ChildJudgeQuery The current query, for fluid interface
     */
    public function prune($judge = null)
    {
        if ($judge) {
            $this->addUsingAlias(JudgeTableMap::COL_ID, $judge->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_judge table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JudgeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JudgeTableMap::clearInstancePool();
            JudgeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(JudgeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JudgeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            JudgeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            JudgeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JudgeQuery

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
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
use iuf\junia\model\Map\RoutineTableMap;

/**
 * Base class that represents a query for the 'kk_junia_routine' table.
 *
 *
 *
 * @method     ChildRoutineQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRoutineQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildRoutineQuery orderByStartgroupId($order = Criteria::ASC) Order by the startgroup_id column
 * @method     ChildRoutineQuery orderByPerformanceTotalStatisticId($order = Criteria::ASC) Order by the performance_total_statistic_id column
 * @method     ChildRoutineQuery orderByPerformanceExecutionStatisticId($order = Criteria::ASC) Order by the performance_execution_statistic_id column
 * @method     ChildRoutineQuery orderByPerformanceChoreographyStatisticId($order = Criteria::ASC) Order by the performance_choreography_statistic_id column
 * @method     ChildRoutineQuery orderByPerformanceMusicAndTimingStatisticId($order = Criteria::ASC) Order by the performance_music_and_timing_statistic_id column
 *
 * @method     ChildRoutineQuery groupById() Group by the id column
 * @method     ChildRoutineQuery groupByName() Group by the name column
 * @method     ChildRoutineQuery groupByStartgroupId() Group by the startgroup_id column
 * @method     ChildRoutineQuery groupByPerformanceTotalStatisticId() Group by the performance_total_statistic_id column
 * @method     ChildRoutineQuery groupByPerformanceExecutionStatisticId() Group by the performance_execution_statistic_id column
 * @method     ChildRoutineQuery groupByPerformanceChoreographyStatisticId() Group by the performance_choreography_statistic_id column
 * @method     ChildRoutineQuery groupByPerformanceMusicAndTimingStatisticId() Group by the performance_music_and_timing_statistic_id column
 *
 * @method     ChildRoutineQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRoutineQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRoutineQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRoutineQuery leftJoinStartgroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Startgroup relation
 * @method     ChildRoutineQuery rightJoinStartgroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Startgroup relation
 * @method     ChildRoutineQuery innerJoinStartgroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Startgroup relation
 *
 * @method     ChildRoutineQuery leftJoinPerformanceTotalStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceTotalStatistic relation
 * @method     ChildRoutineQuery rightJoinPerformanceTotalStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceTotalStatistic relation
 * @method     ChildRoutineQuery innerJoinPerformanceTotalStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceTotalStatistic relation
 *
 * @method     ChildRoutineQuery leftJoinPerformanceExecutionStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceExecutionStatistic relation
 * @method     ChildRoutineQuery rightJoinPerformanceExecutionStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceExecutionStatistic relation
 * @method     ChildRoutineQuery innerJoinPerformanceExecutionStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceExecutionStatistic relation
 *
 * @method     ChildRoutineQuery leftJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceChoreographyStatistic relation
 * @method     ChildRoutineQuery rightJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceChoreographyStatistic relation
 * @method     ChildRoutineQuery innerJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceChoreographyStatistic relation
 *
 * @method     ChildRoutineQuery leftJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 * @method     ChildRoutineQuery rightJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 * @method     ChildRoutineQuery innerJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 *
 * @method     ChildRoutineQuery leftJoinScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Score relation
 * @method     ChildRoutineQuery rightJoinScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Score relation
 * @method     ChildRoutineQuery innerJoinScore($relationAlias = null) Adds a INNER JOIN clause to the query using the Score relation
 *
 * @method     ChildRoutineQuery leftJoinPerformanceScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildRoutineQuery rightJoinPerformanceScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceScore relation
 * @method     ChildRoutineQuery innerJoinPerformanceScore($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceScore relation
 *
 * @method     \iuf\junia\model\StartgroupQuery|\iuf\junia\model\PerformanceStatisticQuery|\iuf\junia\model\ScoreQuery|\iuf\junia\model\PerformanceScoreQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRoutine findOne(ConnectionInterface $con = null) Return the first ChildRoutine matching the query
 * @method     ChildRoutine findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRoutine matching the query, or a new ChildRoutine object populated from the query conditions when no match is found
 *
 * @method     ChildRoutine findOneById(int $id) Return the first ChildRoutine filtered by the id column
 * @method     ChildRoutine findOneByName(string $name) Return the first ChildRoutine filtered by the name column
 * @method     ChildRoutine findOneByStartgroupId(int $startgroup_id) Return the first ChildRoutine filtered by the startgroup_id column
 * @method     ChildRoutine findOneByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return the first ChildRoutine filtered by the performance_total_statistic_id column
 * @method     ChildRoutine findOneByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return the first ChildRoutine filtered by the performance_execution_statistic_id column
 * @method     ChildRoutine findOneByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return the first ChildRoutine filtered by the performance_choreography_statistic_id column
 * @method     ChildRoutine findOneByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return the first ChildRoutine filtered by the performance_music_and_timing_statistic_id column *

 * @method     ChildRoutine requirePk($key, ConnectionInterface $con = null) Return the ChildRoutine by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOne(ConnectionInterface $con = null) Return the first ChildRoutine matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRoutine requireOneById(int $id) Return the first ChildRoutine filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByName(string $name) Return the first ChildRoutine filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByStartgroupId(int $startgroup_id) Return the first ChildRoutine filtered by the startgroup_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return the first ChildRoutine filtered by the performance_total_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return the first ChildRoutine filtered by the performance_execution_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return the first ChildRoutine filtered by the performance_choreography_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRoutine requireOneByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return the first ChildRoutine filtered by the performance_music_and_timing_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRoutine[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRoutine objects based on current ModelCriteria
 * @method     ChildRoutine[]|ObjectCollection findById(int $id) Return ChildRoutine objects filtered by the id column
 * @method     ChildRoutine[]|ObjectCollection findByName(string $name) Return ChildRoutine objects filtered by the name column
 * @method     ChildRoutine[]|ObjectCollection findByStartgroupId(int $startgroup_id) Return ChildRoutine objects filtered by the startgroup_id column
 * @method     ChildRoutine[]|ObjectCollection findByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return ChildRoutine objects filtered by the performance_total_statistic_id column
 * @method     ChildRoutine[]|ObjectCollection findByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return ChildRoutine objects filtered by the performance_execution_statistic_id column
 * @method     ChildRoutine[]|ObjectCollection findByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return ChildRoutine objects filtered by the performance_choreography_statistic_id column
 * @method     ChildRoutine[]|ObjectCollection findByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return ChildRoutine objects filtered by the performance_music_and_timing_statistic_id column
 * @method     ChildRoutine[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RoutineQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\RoutineQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\Routine', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRoutineQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRoutineQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRoutineQuery) {
            return $criteria;
        }
        $query = new ChildRoutineQuery();
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
     * @return ChildRoutine|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RoutineTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RoutineTableMap::DATABASE_NAME);
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
     * @return ChildRoutine A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `name`, `startgroup_id`, `performance_total_statistic_id`, `performance_execution_statistic_id`, `performance_choreography_statistic_id`, `performance_music_and_timing_statistic_id` FROM `kk_junia_routine` WHERE `id` = :p0';
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
            /** @var ChildRoutine $obj */
            $obj = new ChildRoutine();
            $obj->hydrate($row);
            RoutineTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRoutine|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RoutineTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RoutineTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByStartgroupId($startgroupId = null, $comparison = null)
    {
        if (is_array($startgroupId)) {
            $useMinMax = false;
            if (isset($startgroupId['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_STARTGROUP_ID, $startgroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startgroupId['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_STARTGROUP_ID, $startgroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_STARTGROUP_ID, $startgroupId, $comparison);
    }

    /**
     * Filter the query on the performance_total_statistic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerformanceTotalStatisticId(1234); // WHERE performance_total_statistic_id = 1234
     * $query->filterByPerformanceTotalStatisticId(array(12, 34)); // WHERE performance_total_statistic_id IN (12, 34)
     * $query->filterByPerformanceTotalStatisticId(array('min' => 12)); // WHERE performance_total_statistic_id > 12
     * </code>
     *
     * @see       filterByPerformanceTotalStatistic()
     *
     * @param     mixed $performanceTotalStatisticId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceTotalStatisticId($performanceTotalStatisticId = null, $comparison = null)
    {
        if (is_array($performanceTotalStatisticId)) {
            $useMinMax = false;
            if (isset($performanceTotalStatisticId['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceTotalStatisticId['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId, $comparison);
    }

    /**
     * Filter the query on the performance_execution_statistic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerformanceExecutionStatisticId(1234); // WHERE performance_execution_statistic_id = 1234
     * $query->filterByPerformanceExecutionStatisticId(array(12, 34)); // WHERE performance_execution_statistic_id IN (12, 34)
     * $query->filterByPerformanceExecutionStatisticId(array('min' => 12)); // WHERE performance_execution_statistic_id > 12
     * </code>
     *
     * @see       filterByPerformanceExecutionStatistic()
     *
     * @param     mixed $performanceExecutionStatisticId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceExecutionStatisticId($performanceExecutionStatisticId = null, $comparison = null)
    {
        if (is_array($performanceExecutionStatisticId)) {
            $useMinMax = false;
            if (isset($performanceExecutionStatisticId['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceExecutionStatisticId['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId, $comparison);
    }

    /**
     * Filter the query on the performance_choreography_statistic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerformanceChoreographyStatisticId(1234); // WHERE performance_choreography_statistic_id = 1234
     * $query->filterByPerformanceChoreographyStatisticId(array(12, 34)); // WHERE performance_choreography_statistic_id IN (12, 34)
     * $query->filterByPerformanceChoreographyStatisticId(array('min' => 12)); // WHERE performance_choreography_statistic_id > 12
     * </code>
     *
     * @see       filterByPerformanceChoreographyStatistic()
     *
     * @param     mixed $performanceChoreographyStatisticId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceChoreographyStatisticId($performanceChoreographyStatisticId = null, $comparison = null)
    {
        if (is_array($performanceChoreographyStatisticId)) {
            $useMinMax = false;
            if (isset($performanceChoreographyStatisticId['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceChoreographyStatisticId['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId, $comparison);
    }

    /**
     * Filter the query on the performance_music_and_timing_statistic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerformanceMusicAndTimingStatisticId(1234); // WHERE performance_music_and_timing_statistic_id = 1234
     * $query->filterByPerformanceMusicAndTimingStatisticId(array(12, 34)); // WHERE performance_music_and_timing_statistic_id IN (12, 34)
     * $query->filterByPerformanceMusicAndTimingStatisticId(array('min' => 12)); // WHERE performance_music_and_timing_statistic_id > 12
     * </code>
     *
     * @see       filterByPerformanceMusicAndTimingStatistic()
     *
     * @param     mixed $performanceMusicAndTimingStatisticId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceMusicAndTimingStatisticId($performanceMusicAndTimingStatisticId = null, $comparison = null)
    {
        if (is_array($performanceMusicAndTimingStatisticId)) {
            $useMinMax = false;
            if (isset($performanceMusicAndTimingStatisticId['min'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceMusicAndTimingStatisticId['max'])) {
                $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByStartgroup($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_STARTGROUP_ID, $startgroup->getId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoutineTableMap::COL_STARTGROUP_ID, $startgroup->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
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
     * Filter the query by a related \iuf\junia\model\PerformanceStatistic object
     *
     * @param \iuf\junia\model\PerformanceStatistic|ObjectCollection $performanceStatistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceTotalStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerformanceTotalStatistic() only accepts arguments of type \iuf\junia\model\PerformanceStatistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PerformanceTotalStatistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function joinPerformanceTotalStatistic($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PerformanceTotalStatistic');

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
            $this->addJoinObject($join, 'PerformanceTotalStatistic');
        }

        return $this;
    }

    /**
     * Use the PerformanceTotalStatistic relation PerformanceStatistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\PerformanceStatisticQuery A secondary query class using the current class as primary query
     */
    public function usePerformanceTotalStatisticQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerformanceTotalStatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceTotalStatistic', '\iuf\junia\model\PerformanceStatisticQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceStatistic object
     *
     * @param \iuf\junia\model\PerformanceStatistic|ObjectCollection $performanceStatistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceExecutionStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerformanceExecutionStatistic() only accepts arguments of type \iuf\junia\model\PerformanceStatistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PerformanceExecutionStatistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function joinPerformanceExecutionStatistic($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PerformanceExecutionStatistic');

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
            $this->addJoinObject($join, 'PerformanceExecutionStatistic');
        }

        return $this;
    }

    /**
     * Use the PerformanceExecutionStatistic relation PerformanceStatistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\PerformanceStatisticQuery A secondary query class using the current class as primary query
     */
    public function usePerformanceExecutionStatisticQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerformanceExecutionStatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceExecutionStatistic', '\iuf\junia\model\PerformanceStatisticQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceStatistic object
     *
     * @param \iuf\junia\model\PerformanceStatistic|ObjectCollection $performanceStatistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceChoreographyStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerformanceChoreographyStatistic() only accepts arguments of type \iuf\junia\model\PerformanceStatistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PerformanceChoreographyStatistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function joinPerformanceChoreographyStatistic($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PerformanceChoreographyStatistic');

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
            $this->addJoinObject($join, 'PerformanceChoreographyStatistic');
        }

        return $this;
    }

    /**
     * Use the PerformanceChoreographyStatistic relation PerformanceStatistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\PerformanceStatisticQuery A secondary query class using the current class as primary query
     */
    public function usePerformanceChoreographyStatisticQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerformanceChoreographyStatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceChoreographyStatistic', '\iuf\junia\model\PerformanceStatisticQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceStatistic object
     *
     * @param \iuf\junia\model\PerformanceStatistic|ObjectCollection $performanceStatistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceMusicAndTimingStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerformanceMusicAndTimingStatistic() only accepts arguments of type \iuf\junia\model\PerformanceStatistic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function joinPerformanceMusicAndTimingStatistic($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PerformanceMusicAndTimingStatistic');

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
            $this->addJoinObject($join, 'PerformanceMusicAndTimingStatistic');
        }

        return $this;
    }

    /**
     * Use the PerformanceMusicAndTimingStatistic relation PerformanceStatistic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\PerformanceStatisticQuery A secondary query class using the current class as primary query
     */
    public function usePerformanceMusicAndTimingStatisticQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPerformanceMusicAndTimingStatistic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PerformanceMusicAndTimingStatistic', '\iuf\junia\model\PerformanceStatisticQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Score object
     *
     * @param \iuf\junia\model\Score|ObjectCollection $score the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByScore($score, $comparison = null)
    {
        if ($score instanceof \iuf\junia\model\Score) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_ID, $score->getRoutineId(), $comparison);
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
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
     * @return ChildRoutineQuery The current query, for fluid interface
     */
    public function filterByPerformanceScore($performanceScore, $comparison = null)
    {
        if ($performanceScore instanceof \iuf\junia\model\PerformanceScore) {
            return $this
                ->addUsingAlias(RoutineTableMap::COL_ID, $performanceScore->getRoutineId(), $comparison);
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
     * @return $this|ChildRoutineQuery The current query, for fluid interface
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
     * @param   ChildRoutine $routine Object to remove from the list of results
     *
     * @return $this|ChildRoutineQuery The current query, for fluid interface
     */
    public function prune($routine = null)
    {
        if ($routine) {
            $this->addUsingAlias(RoutineTableMap::COL_ID, $routine->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_routine table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoutineTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RoutineTableMap::clearInstancePool();
            RoutineTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RoutineTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RoutineTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RoutineTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RoutineTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RoutineQuery

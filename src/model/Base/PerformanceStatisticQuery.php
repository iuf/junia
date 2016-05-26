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
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Map\PerformanceStatisticTableMap;

/**
 * Base class that represents a query for the 'kk_junia_performance_statistic' table.
 *
 *
 *
 * @method     ChildPerformanceStatisticQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPerformanceStatisticQuery orderByMin($order = Criteria::ASC) Order by the min column
 * @method     ChildPerformanceStatisticQuery orderByMax($order = Criteria::ASC) Order by the max column
 * @method     ChildPerformanceStatisticQuery orderByRange($order = Criteria::ASC) Order by the range column
 * @method     ChildPerformanceStatisticQuery orderByMedian($order = Criteria::ASC) Order by the median column
 * @method     ChildPerformanceStatisticQuery orderByAverage($order = Criteria::ASC) Order by the average column
 * @method     ChildPerformanceStatisticQuery orderByVariance($order = Criteria::ASC) Order by the variance column
 * @method     ChildPerformanceStatisticQuery orderByStandardDeviation($order = Criteria::ASC) Order by the standard_deviation column
 * @method     ChildPerformanceStatisticQuery orderByVariabilityCoefficient($order = Criteria::ASC) Order by the variability_coefficient column
 *
 * @method     ChildPerformanceStatisticQuery groupById() Group by the id column
 * @method     ChildPerformanceStatisticQuery groupByMin() Group by the min column
 * @method     ChildPerformanceStatisticQuery groupByMax() Group by the max column
 * @method     ChildPerformanceStatisticQuery groupByRange() Group by the range column
 * @method     ChildPerformanceStatisticQuery groupByMedian() Group by the median column
 * @method     ChildPerformanceStatisticQuery groupByAverage() Group by the average column
 * @method     ChildPerformanceStatisticQuery groupByVariance() Group by the variance column
 * @method     ChildPerformanceStatisticQuery groupByStandardDeviation() Group by the standard_deviation column
 * @method     ChildPerformanceStatisticQuery groupByVariabilityCoefficient() Group by the variability_coefficient column
 *
 * @method     ChildPerformanceStatisticQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPerformanceStatisticQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPerformanceStatisticQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPerformanceStatisticQuery leftJoinEventRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinEventRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinEventRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the EventRelatedByPerformanceTotalStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinEventRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinEventRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinEventRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the EventRelatedByPerformanceExecutionStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinEventRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinEventRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinEventRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the EventRelatedByPerformanceChoreographyStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinEventRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinEventRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinEventRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the EventRelatedByPerformanceMusicAndTimingStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinStartgroupRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StartgroupRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinStartgroupRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StartgroupRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinStartgroupRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the StartgroupRelatedByPerformanceTotalStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinStartgroupRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StartgroupRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinStartgroupRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StartgroupRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinStartgroupRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the StartgroupRelatedByPerformanceExecutionStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinStartgroupRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StartgroupRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinStartgroupRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StartgroupRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinStartgroupRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the StartgroupRelatedByPerformanceChoreographyStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the StartgroupRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StartgroupRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the StartgroupRelatedByPerformanceMusicAndTimingStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinRoutineRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinRoutineRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinRoutineRelatedByPerformanceTotalStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinRoutineRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinRoutineRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinRoutineRelatedByPerformanceExecutionStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinRoutineRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinRoutineRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinRoutineRelatedByPerformanceChoreographyStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticId relation
 *
 * @method     ChildPerformanceStatisticQuery leftJoinRoutineRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery rightJoinRoutineRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticId relation
 * @method     ChildPerformanceStatisticQuery innerJoinRoutineRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticId relation
 *
 * @method     \iuf\junia\model\EventQuery|\iuf\junia\model\StartgroupQuery|\iuf\junia\model\RoutineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPerformanceStatistic findOne(ConnectionInterface $con = null) Return the first ChildPerformanceStatistic matching the query
 * @method     ChildPerformanceStatistic findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPerformanceStatistic matching the query, or a new ChildPerformanceStatistic object populated from the query conditions when no match is found
 *
 * @method     ChildPerformanceStatistic findOneById(int $id) Return the first ChildPerformanceStatistic filtered by the id column
 * @method     ChildPerformanceStatistic findOneByMin(double $min) Return the first ChildPerformanceStatistic filtered by the min column
 * @method     ChildPerformanceStatistic findOneByMax(double $max) Return the first ChildPerformanceStatistic filtered by the max column
 * @method     ChildPerformanceStatistic findOneByRange(double $range) Return the first ChildPerformanceStatistic filtered by the range column
 * @method     ChildPerformanceStatistic findOneByMedian(double $median) Return the first ChildPerformanceStatistic filtered by the median column
 * @method     ChildPerformanceStatistic findOneByAverage(double $average) Return the first ChildPerformanceStatistic filtered by the average column
 * @method     ChildPerformanceStatistic findOneByVariance(double $variance) Return the first ChildPerformanceStatistic filtered by the variance column
 * @method     ChildPerformanceStatistic findOneByStandardDeviation(double $standard_deviation) Return the first ChildPerformanceStatistic filtered by the standard_deviation column
 * @method     ChildPerformanceStatistic findOneByVariabilityCoefficient(double $variability_coefficient) Return the first ChildPerformanceStatistic filtered by the variability_coefficient column *

 * @method     ChildPerformanceStatistic requirePk($key, ConnectionInterface $con = null) Return the ChildPerformanceStatistic by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOne(ConnectionInterface $con = null) Return the first ChildPerformanceStatistic matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerformanceStatistic requireOneById(int $id) Return the first ChildPerformanceStatistic filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByMin(double $min) Return the first ChildPerformanceStatistic filtered by the min column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByMax(double $max) Return the first ChildPerformanceStatistic filtered by the max column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByRange(double $range) Return the first ChildPerformanceStatistic filtered by the range column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByMedian(double $median) Return the first ChildPerformanceStatistic filtered by the median column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByAverage(double $average) Return the first ChildPerformanceStatistic filtered by the average column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByVariance(double $variance) Return the first ChildPerformanceStatistic filtered by the variance column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByStandardDeviation(double $standard_deviation) Return the first ChildPerformanceStatistic filtered by the standard_deviation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistic requireOneByVariabilityCoefficient(double $variability_coefficient) Return the first ChildPerformanceStatistic filtered by the variability_coefficient column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerformanceStatistic[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPerformanceStatistic objects based on current ModelCriteria
 * @method     ChildPerformanceStatistic[]|ObjectCollection findById(int $id) Return ChildPerformanceStatistic objects filtered by the id column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByMin(double $min) Return ChildPerformanceStatistic objects filtered by the min column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByMax(double $max) Return ChildPerformanceStatistic objects filtered by the max column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByRange(double $range) Return ChildPerformanceStatistic objects filtered by the range column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByMedian(double $median) Return ChildPerformanceStatistic objects filtered by the median column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByAverage(double $average) Return ChildPerformanceStatistic objects filtered by the average column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByVariance(double $variance) Return ChildPerformanceStatistic objects filtered by the variance column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByStandardDeviation(double $standard_deviation) Return ChildPerformanceStatistic objects filtered by the standard_deviation column
 * @method     ChildPerformanceStatistic[]|ObjectCollection findByVariabilityCoefficient(double $variability_coefficient) Return ChildPerformanceStatistic objects filtered by the variability_coefficient column
 * @method     ChildPerformanceStatistic[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PerformanceStatisticQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\PerformanceStatisticQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\PerformanceStatistic', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPerformanceStatisticQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPerformanceStatisticQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPerformanceStatisticQuery) {
            return $criteria;
        }
        $query = new ChildPerformanceStatisticQuery();
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
     * @return ChildPerformanceStatistic|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PerformanceStatisticTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PerformanceStatisticTableMap::DATABASE_NAME);
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
     * @return ChildPerformanceStatistic A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `min`, `max`, `range`, `median`, `average`, `variance`, `standard_deviation`, `variability_coefficient` FROM `kk_junia_performance_statistic` WHERE `id` = :p0';
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
            /** @var ChildPerformanceStatistic $obj */
            $obj = new ChildPerformanceStatistic();
            $obj->hydrate($row);
            PerformanceStatisticTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPerformanceStatistic|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the min column
     *
     * Example usage:
     * <code>
     * $query->filterByMin(1234); // WHERE min = 1234
     * $query->filterByMin(array(12, 34)); // WHERE min IN (12, 34)
     * $query->filterByMin(array('min' => 12)); // WHERE min > 12
     * </code>
     *
     * @param     mixed $min The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByMin($min = null, $comparison = null)
    {
        if (is_array($min)) {
            $useMinMax = false;
            if (isset($min['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MIN, $min['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($min['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MIN, $min['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_MIN, $min, $comparison);
    }

    /**
     * Filter the query on the max column
     *
     * Example usage:
     * <code>
     * $query->filterByMax(1234); // WHERE max = 1234
     * $query->filterByMax(array(12, 34)); // WHERE max IN (12, 34)
     * $query->filterByMax(array('min' => 12)); // WHERE max > 12
     * </code>
     *
     * @param     mixed $max The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByMax($max = null, $comparison = null)
    {
        if (is_array($max)) {
            $useMinMax = false;
            if (isset($max['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MAX, $max['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($max['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MAX, $max['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_MAX, $max, $comparison);
    }

    /**
     * Filter the query on the range column
     *
     * Example usage:
     * <code>
     * $query->filterByRange(1234); // WHERE range = 1234
     * $query->filterByRange(array(12, 34)); // WHERE range IN (12, 34)
     * $query->filterByRange(array('min' => 12)); // WHERE range > 12
     * </code>
     *
     * @param     mixed $range The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByRange($range = null, $comparison = null)
    {
        if (is_array($range)) {
            $useMinMax = false;
            if (isset($range['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_RANGE, $range['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($range['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_RANGE, $range['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_RANGE, $range, $comparison);
    }

    /**
     * Filter the query on the median column
     *
     * Example usage:
     * <code>
     * $query->filterByMedian(1234); // WHERE median = 1234
     * $query->filterByMedian(array(12, 34)); // WHERE median IN (12, 34)
     * $query->filterByMedian(array('min' => 12)); // WHERE median > 12
     * </code>
     *
     * @param     mixed $median The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByMedian($median = null, $comparison = null)
    {
        if (is_array($median)) {
            $useMinMax = false;
            if (isset($median['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MEDIAN, $median['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($median['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_MEDIAN, $median['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_MEDIAN, $median, $comparison);
    }

    /**
     * Filter the query on the average column
     *
     * Example usage:
     * <code>
     * $query->filterByAverage(1234); // WHERE average = 1234
     * $query->filterByAverage(array(12, 34)); // WHERE average IN (12, 34)
     * $query->filterByAverage(array('min' => 12)); // WHERE average > 12
     * </code>
     *
     * @param     mixed $average The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByAverage($average = null, $comparison = null)
    {
        if (is_array($average)) {
            $useMinMax = false;
            if (isset($average['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_AVERAGE, $average['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($average['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_AVERAGE, $average['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_AVERAGE, $average, $comparison);
    }

    /**
     * Filter the query on the variance column
     *
     * Example usage:
     * <code>
     * $query->filterByVariance(1234); // WHERE variance = 1234
     * $query->filterByVariance(array(12, 34)); // WHERE variance IN (12, 34)
     * $query->filterByVariance(array('min' => 12)); // WHERE variance > 12
     * </code>
     *
     * @param     mixed $variance The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByVariance($variance = null, $comparison = null)
    {
        if (is_array($variance)) {
            $useMinMax = false;
            if (isset($variance['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIANCE, $variance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variance['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIANCE, $variance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIANCE, $variance, $comparison);
    }

    /**
     * Filter the query on the standard_deviation column
     *
     * Example usage:
     * <code>
     * $query->filterByStandardDeviation(1234); // WHERE standard_deviation = 1234
     * $query->filterByStandardDeviation(array(12, 34)); // WHERE standard_deviation IN (12, 34)
     * $query->filterByStandardDeviation(array('min' => 12)); // WHERE standard_deviation > 12
     * </code>
     *
     * @param     mixed $standardDeviation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByStandardDeviation($standardDeviation = null, $comparison = null)
    {
        if (is_array($standardDeviation)) {
            $useMinMax = false;
            if (isset($standardDeviation['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION, $standardDeviation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($standardDeviation['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION, $standardDeviation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION, $standardDeviation, $comparison);
    }

    /**
     * Filter the query on the variability_coefficient column
     *
     * Example usage:
     * <code>
     * $query->filterByVariabilityCoefficient(1234); // WHERE variability_coefficient = 1234
     * $query->filterByVariabilityCoefficient(array(12, 34)); // WHERE variability_coefficient IN (12, 34)
     * $query->filterByVariabilityCoefficient(array('min' => 12)); // WHERE variability_coefficient > 12
     * </code>
     *
     * @param     mixed $variabilityCoefficient The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByVariabilityCoefficient($variabilityCoefficient = null, $comparison = null)
    {
        if (is_array($variabilityCoefficient)) {
            $useMinMax = false;
            if (isset($variabilityCoefficient['min'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT, $variabilityCoefficient['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variabilityCoefficient['max'])) {
                $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT, $variabilityCoefficient['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT, $variabilityCoefficient, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Event object
     *
     * @param \iuf\junia\model\Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByEventRelatedByPerformanceTotalStatisticId($event, $comparison = null)
    {
        if ($event instanceof \iuf\junia\model\Event) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $event->getPerformanceTotalStatisticId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventRelatedByPerformanceTotalStatisticIdQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventRelatedByPerformanceTotalStatisticId() only accepts arguments of type \iuf\junia\model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventRelatedByPerformanceTotalStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinEventRelatedByPerformanceTotalStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventRelatedByPerformanceTotalStatisticId');

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
            $this->addJoinObject($join, 'EventRelatedByPerformanceTotalStatisticId');
        }

        return $this;
    }

    /**
     * Use the EventRelatedByPerformanceTotalStatisticId relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventRelatedByPerformanceTotalStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEventRelatedByPerformanceTotalStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventRelatedByPerformanceTotalStatisticId', '\iuf\junia\model\EventQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Event object
     *
     * @param \iuf\junia\model\Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByEventRelatedByPerformanceExecutionStatisticId($event, $comparison = null)
    {
        if ($event instanceof \iuf\junia\model\Event) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $event->getPerformanceExecutionStatisticId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventRelatedByPerformanceExecutionStatisticIdQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventRelatedByPerformanceExecutionStatisticId() only accepts arguments of type \iuf\junia\model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventRelatedByPerformanceExecutionStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinEventRelatedByPerformanceExecutionStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventRelatedByPerformanceExecutionStatisticId');

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
            $this->addJoinObject($join, 'EventRelatedByPerformanceExecutionStatisticId');
        }

        return $this;
    }

    /**
     * Use the EventRelatedByPerformanceExecutionStatisticId relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventRelatedByPerformanceExecutionStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEventRelatedByPerformanceExecutionStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventRelatedByPerformanceExecutionStatisticId', '\iuf\junia\model\EventQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Event object
     *
     * @param \iuf\junia\model\Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByEventRelatedByPerformanceChoreographyStatisticId($event, $comparison = null)
    {
        if ($event instanceof \iuf\junia\model\Event) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $event->getPerformanceChoreographyStatisticId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventRelatedByPerformanceChoreographyStatisticIdQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventRelatedByPerformanceChoreographyStatisticId() only accepts arguments of type \iuf\junia\model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventRelatedByPerformanceChoreographyStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinEventRelatedByPerformanceChoreographyStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventRelatedByPerformanceChoreographyStatisticId');

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
            $this->addJoinObject($join, 'EventRelatedByPerformanceChoreographyStatisticId');
        }

        return $this;
    }

    /**
     * Use the EventRelatedByPerformanceChoreographyStatisticId relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventRelatedByPerformanceChoreographyStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEventRelatedByPerformanceChoreographyStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventRelatedByPerformanceChoreographyStatisticId', '\iuf\junia\model\EventQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Event object
     *
     * @param \iuf\junia\model\Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByEventRelatedByPerformanceMusicAndTimingStatisticId($event, $comparison = null)
    {
        if ($event instanceof \iuf\junia\model\Event) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $event->getPerformanceMusicAndTimingStatisticId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventRelatedByPerformanceMusicAndTimingStatisticIdQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventRelatedByPerformanceMusicAndTimingStatisticId() only accepts arguments of type \iuf\junia\model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EventRelatedByPerformanceMusicAndTimingStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinEventRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventRelatedByPerformanceMusicAndTimingStatisticId');

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
            $this->addJoinObject($join, 'EventRelatedByPerformanceMusicAndTimingStatisticId');
        }

        return $this;
    }

    /**
     * Use the EventRelatedByPerformanceMusicAndTimingStatisticId relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventRelatedByPerformanceMusicAndTimingStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEventRelatedByPerformanceMusicAndTimingStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EventRelatedByPerformanceMusicAndTimingStatisticId', '\iuf\junia\model\EventQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByStartgroupRelatedByPerformanceTotalStatisticId($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $startgroup->getPerformanceTotalStatisticId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            return $this
                ->useStartgroupRelatedByPerformanceTotalStatisticIdQuery()
                ->filterByPrimaryKeys($startgroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStartgroupRelatedByPerformanceTotalStatisticId() only accepts arguments of type \iuf\junia\model\Startgroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StartgroupRelatedByPerformanceTotalStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinStartgroupRelatedByPerformanceTotalStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StartgroupRelatedByPerformanceTotalStatisticId');

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
            $this->addJoinObject($join, 'StartgroupRelatedByPerformanceTotalStatisticId');
        }

        return $this;
    }

    /**
     * Use the StartgroupRelatedByPerformanceTotalStatisticId relation Startgroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\StartgroupQuery A secondary query class using the current class as primary query
     */
    public function useStartgroupRelatedByPerformanceTotalStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStartgroupRelatedByPerformanceTotalStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StartgroupRelatedByPerformanceTotalStatisticId', '\iuf\junia\model\StartgroupQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByStartgroupRelatedByPerformanceExecutionStatisticId($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $startgroup->getPerformanceExecutionStatisticId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            return $this
                ->useStartgroupRelatedByPerformanceExecutionStatisticIdQuery()
                ->filterByPrimaryKeys($startgroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStartgroupRelatedByPerformanceExecutionStatisticId() only accepts arguments of type \iuf\junia\model\Startgroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StartgroupRelatedByPerformanceExecutionStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinStartgroupRelatedByPerformanceExecutionStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StartgroupRelatedByPerformanceExecutionStatisticId');

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
            $this->addJoinObject($join, 'StartgroupRelatedByPerformanceExecutionStatisticId');
        }

        return $this;
    }

    /**
     * Use the StartgroupRelatedByPerformanceExecutionStatisticId relation Startgroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\StartgroupQuery A secondary query class using the current class as primary query
     */
    public function useStartgroupRelatedByPerformanceExecutionStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStartgroupRelatedByPerformanceExecutionStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StartgroupRelatedByPerformanceExecutionStatisticId', '\iuf\junia\model\StartgroupQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByStartgroupRelatedByPerformanceChoreographyStatisticId($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $startgroup->getPerformanceChoreographyStatisticId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            return $this
                ->useStartgroupRelatedByPerformanceChoreographyStatisticIdQuery()
                ->filterByPrimaryKeys($startgroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStartgroupRelatedByPerformanceChoreographyStatisticId() only accepts arguments of type \iuf\junia\model\Startgroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StartgroupRelatedByPerformanceChoreographyStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinStartgroupRelatedByPerformanceChoreographyStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StartgroupRelatedByPerformanceChoreographyStatisticId');

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
            $this->addJoinObject($join, 'StartgroupRelatedByPerformanceChoreographyStatisticId');
        }

        return $this;
    }

    /**
     * Use the StartgroupRelatedByPerformanceChoreographyStatisticId relation Startgroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\StartgroupQuery A secondary query class using the current class as primary query
     */
    public function useStartgroupRelatedByPerformanceChoreographyStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStartgroupRelatedByPerformanceChoreographyStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StartgroupRelatedByPerformanceChoreographyStatisticId', '\iuf\junia\model\StartgroupQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Startgroup object
     *
     * @param \iuf\junia\model\Startgroup|ObjectCollection $startgroup the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByStartgroupRelatedByPerformanceMusicAndTimingStatisticId($startgroup, $comparison = null)
    {
        if ($startgroup instanceof \iuf\junia\model\Startgroup) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $startgroup->getPerformanceMusicAndTimingStatisticId(), $comparison);
        } elseif ($startgroup instanceof ObjectCollection) {
            return $this
                ->useStartgroupRelatedByPerformanceMusicAndTimingStatisticIdQuery()
                ->filterByPrimaryKeys($startgroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStartgroupRelatedByPerformanceMusicAndTimingStatisticId() only accepts arguments of type \iuf\junia\model\Startgroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StartgroupRelatedByPerformanceMusicAndTimingStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StartgroupRelatedByPerformanceMusicAndTimingStatisticId');

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
            $this->addJoinObject($join, 'StartgroupRelatedByPerformanceMusicAndTimingStatisticId');
        }

        return $this;
    }

    /**
     * Use the StartgroupRelatedByPerformanceMusicAndTimingStatisticId relation Startgroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\StartgroupQuery A secondary query class using the current class as primary query
     */
    public function useStartgroupRelatedByPerformanceMusicAndTimingStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StartgroupRelatedByPerformanceMusicAndTimingStatisticId', '\iuf\junia\model\StartgroupQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceTotalStatisticId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $routine->getPerformanceTotalStatisticId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceTotalStatisticIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceTotalStatisticId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceTotalStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceTotalStatisticId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceTotalStatisticId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceTotalStatisticId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceTotalStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceTotalStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceTotalStatisticId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceExecutionStatisticId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $routine->getPerformanceExecutionStatisticId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceExecutionStatisticIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceExecutionStatisticId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceExecutionStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceExecutionStatisticId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceExecutionStatisticId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceExecutionStatisticId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceExecutionStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceExecutionStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceExecutionStatisticId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceChoreographyStatisticId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $routine->getPerformanceChoreographyStatisticId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceChoreographyStatisticIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceChoreographyStatisticId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceChoreographyStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceChoreographyStatisticId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceChoreographyStatisticId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceChoreographyStatisticId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceChoreographyStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceChoreographyStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceChoreographyStatisticId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceMusicAndTimingStatisticId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $routine->getPerformanceMusicAndTimingStatisticId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceMusicAndTimingStatisticIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceMusicAndTimingStatisticId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceMusicAndTimingStatisticId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceMusicAndTimingStatisticId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceMusicAndTimingStatisticId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceMusicAndTimingStatisticId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceMusicAndTimingStatisticIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceMusicAndTimingStatisticId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceMusicAndTimingStatisticId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPerformanceStatistic $performanceStatistic Object to remove from the list of results
     *
     * @return $this|ChildPerformanceStatisticQuery The current query, for fluid interface
     */
    public function prune($performanceStatistic = null)
    {
        if ($performanceStatistic) {
            $this->addUsingAlias(PerformanceStatisticTableMap::COL_ID, $performanceStatistic->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_performance_statistic table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PerformanceStatisticTableMap::clearInstancePool();
            PerformanceStatisticTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PerformanceStatisticTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PerformanceStatisticTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PerformanceStatisticTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PerformanceStatisticQuery

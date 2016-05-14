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
use iuf\junia\model\PerformanceStatistics as ChildPerformanceStatistics;
use iuf\junia\model\PerformanceStatisticsQuery as ChildPerformanceStatisticsQuery;
use iuf\junia\model\Map\PerformanceStatisticsTableMap;

/**
 * Base class that represents a query for the 'kk_junia_performance_statistics' table.
 *
 *
 *
 * @method     ChildPerformanceStatisticsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPerformanceStatisticsQuery orderByMin($order = Criteria::ASC) Order by the min column
 * @method     ChildPerformanceStatisticsQuery orderByMax($order = Criteria::ASC) Order by the max column
 * @method     ChildPerformanceStatisticsQuery orderByRange($order = Criteria::ASC) Order by the range column
 * @method     ChildPerformanceStatisticsQuery orderByAverage($order = Criteria::ASC) Order by the average column
 * @method     ChildPerformanceStatisticsQuery orderByStandardDeviation($order = Criteria::ASC) Order by the standard_deviation column
 * @method     ChildPerformanceStatisticsQuery orderByVariance($order = Criteria::ASC) Order by the variance column
 *
 * @method     ChildPerformanceStatisticsQuery groupById() Group by the id column
 * @method     ChildPerformanceStatisticsQuery groupByMin() Group by the min column
 * @method     ChildPerformanceStatisticsQuery groupByMax() Group by the max column
 * @method     ChildPerformanceStatisticsQuery groupByRange() Group by the range column
 * @method     ChildPerformanceStatisticsQuery groupByAverage() Group by the average column
 * @method     ChildPerformanceStatisticsQuery groupByStandardDeviation() Group by the standard_deviation column
 * @method     ChildPerformanceStatisticsQuery groupByVariance() Group by the variance column
 *
 * @method     ChildPerformanceStatisticsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPerformanceStatisticsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPerformanceStatisticsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPerformanceStatisticsQuery leftJoinRoutineRelatedByPerformanceTotalStatisticsId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery rightJoinRoutineRelatedByPerformanceTotalStatisticsId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery innerJoinRoutineRelatedByPerformanceTotalStatisticsId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticsId relation
 *
 * @method     ChildPerformanceStatisticsQuery leftJoinRoutineRelatedByPerformanceExecutionStatisticsId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery rightJoinRoutineRelatedByPerformanceExecutionStatisticsId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery innerJoinRoutineRelatedByPerformanceExecutionStatisticsId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticsId relation
 *
 * @method     ChildPerformanceStatisticsQuery leftJoinRoutineRelatedByPerformanceChoreographyStatisticsId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery rightJoinRoutineRelatedByPerformanceChoreographyStatisticsId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery innerJoinRoutineRelatedByPerformanceChoreographyStatisticsId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticsId relation
 *
 * @method     ChildPerformanceStatisticsQuery leftJoinRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery rightJoinRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticsId relation
 * @method     ChildPerformanceStatisticsQuery innerJoinRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relationAlias = null) Adds a INNER JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticsId relation
 *
 * @method     \iuf\junia\model\RoutineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPerformanceStatistics findOne(ConnectionInterface $con = null) Return the first ChildPerformanceStatistics matching the query
 * @method     ChildPerformanceStatistics findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPerformanceStatistics matching the query, or a new ChildPerformanceStatistics object populated from the query conditions when no match is found
 *
 * @method     ChildPerformanceStatistics findOneById(int $id) Return the first ChildPerformanceStatistics filtered by the id column
 * @method     ChildPerformanceStatistics findOneByMin(double $min) Return the first ChildPerformanceStatistics filtered by the min column
 * @method     ChildPerformanceStatistics findOneByMax(double $max) Return the first ChildPerformanceStatistics filtered by the max column
 * @method     ChildPerformanceStatistics findOneByRange(double $range) Return the first ChildPerformanceStatistics filtered by the range column
 * @method     ChildPerformanceStatistics findOneByAverage(double $average) Return the first ChildPerformanceStatistics filtered by the average column
 * @method     ChildPerformanceStatistics findOneByStandardDeviation(double $standard_deviation) Return the first ChildPerformanceStatistics filtered by the standard_deviation column
 * @method     ChildPerformanceStatistics findOneByVariance(double $variance) Return the first ChildPerformanceStatistics filtered by the variance column *

 * @method     ChildPerformanceStatistics requirePk($key, ConnectionInterface $con = null) Return the ChildPerformanceStatistics by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOne(ConnectionInterface $con = null) Return the first ChildPerformanceStatistics matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerformanceStatistics requireOneById(int $id) Return the first ChildPerformanceStatistics filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByMin(double $min) Return the first ChildPerformanceStatistics filtered by the min column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByMax(double $max) Return the first ChildPerformanceStatistics filtered by the max column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByRange(double $range) Return the first ChildPerformanceStatistics filtered by the range column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByAverage(double $average) Return the first ChildPerformanceStatistics filtered by the average column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByStandardDeviation(double $standard_deviation) Return the first ChildPerformanceStatistics filtered by the standard_deviation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerformanceStatistics requireOneByVariance(double $variance) Return the first ChildPerformanceStatistics filtered by the variance column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerformanceStatistics[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPerformanceStatistics objects based on current ModelCriteria
 * @method     ChildPerformanceStatistics[]|ObjectCollection findById(int $id) Return ChildPerformanceStatistics objects filtered by the id column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByMin(double $min) Return ChildPerformanceStatistics objects filtered by the min column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByMax(double $max) Return ChildPerformanceStatistics objects filtered by the max column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByRange(double $range) Return ChildPerformanceStatistics objects filtered by the range column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByAverage(double $average) Return ChildPerformanceStatistics objects filtered by the average column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByStandardDeviation(double $standard_deviation) Return ChildPerformanceStatistics objects filtered by the standard_deviation column
 * @method     ChildPerformanceStatistics[]|ObjectCollection findByVariance(double $variance) Return ChildPerformanceStatistics objects filtered by the variance column
 * @method     ChildPerformanceStatistics[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PerformanceStatisticsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\PerformanceStatisticsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\PerformanceStatistics', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPerformanceStatisticsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPerformanceStatisticsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPerformanceStatisticsQuery) {
            return $criteria;
        }
        $query = new ChildPerformanceStatisticsQuery();
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
     * @return ChildPerformanceStatistics|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PerformanceStatisticsTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
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
     * @return ChildPerformanceStatistics A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `min`, `max`, `range`, `average`, `standard_deviation`, `variance` FROM `kk_junia_performance_statistics` WHERE `id` = :p0';
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
            /** @var ChildPerformanceStatistics $obj */
            $obj = new ChildPerformanceStatistics();
            $obj->hydrate($row);
            PerformanceStatisticsTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPerformanceStatistics|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByMin($min = null, $comparison = null)
    {
        if (is_array($min)) {
            $useMinMax = false;
            if (isset($min['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MIN, $min['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($min['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MIN, $min['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MIN, $min, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByMax($max = null, $comparison = null)
    {
        if (is_array($max)) {
            $useMinMax = false;
            if (isset($max['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MAX, $max['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($max['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MAX, $max['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_MAX, $max, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByRange($range = null, $comparison = null)
    {
        if (is_array($range)) {
            $useMinMax = false;
            if (isset($range['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_RANGE, $range['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($range['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_RANGE, $range['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_RANGE, $range, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByAverage($average = null, $comparison = null)
    {
        if (is_array($average)) {
            $useMinMax = false;
            if (isset($average['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_AVERAGE, $average['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($average['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_AVERAGE, $average['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_AVERAGE, $average, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByStandardDeviation($standardDeviation = null, $comparison = null)
    {
        if (is_array($standardDeviation)) {
            $useMinMax = false;
            if (isset($standardDeviation['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION, $standardDeviation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($standardDeviation['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION, $standardDeviation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION, $standardDeviation, $comparison);
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
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByVariance($variance = null, $comparison = null)
    {
        if (is_array($variance)) {
            $useMinMax = false;
            if (isset($variance['min'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_VARIANCE, $variance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variance['max'])) {
                $this->addUsingAlias(PerformanceStatisticsTableMap::COL_VARIANCE, $variance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PerformanceStatisticsTableMap::COL_VARIANCE, $variance, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceTotalStatisticsId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $routine->getPerformanceTotalStatisticsId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceTotalStatisticsIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceTotalStatisticsId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceTotalStatisticsId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceTotalStatisticsId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceTotalStatisticsId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceTotalStatisticsId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceTotalStatisticsId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceTotalStatisticsIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceTotalStatisticsId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceTotalStatisticsId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceExecutionStatisticsId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $routine->getPerformanceExecutionStatisticsId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceExecutionStatisticsIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceExecutionStatisticsId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceExecutionStatisticsId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceExecutionStatisticsId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceExecutionStatisticsId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceExecutionStatisticsId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceExecutionStatisticsId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceExecutionStatisticsIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceExecutionStatisticsId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceExecutionStatisticsId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceChoreographyStatisticsId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $routine->getPerformanceChoreographyStatisticsId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceChoreographyStatisticsIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceChoreographyStatisticsId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceChoreographyStatisticsId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceChoreographyStatisticsId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceChoreographyStatisticsId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceChoreographyStatisticsId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceChoreographyStatisticsId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceChoreographyStatisticsIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceChoreographyStatisticsId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceChoreographyStatisticsId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function filterByRoutineRelatedByPerformanceMusicAndTimingStatisticsId($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $routine->getPerformanceMusicAndTimingStatisticsId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineRelatedByPerformanceMusicAndTimingStatisticsIdQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoutineRelatedByPerformanceMusicAndTimingStatisticsId() only accepts arguments of type \iuf\junia\model\Routine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoutineRelatedByPerformanceMusicAndTimingStatisticsId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function joinRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoutineRelatedByPerformanceMusicAndTimingStatisticsId');

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
            $this->addJoinObject($join, 'RoutineRelatedByPerformanceMusicAndTimingStatisticsId');
        }

        return $this;
    }

    /**
     * Use the RoutineRelatedByPerformanceMusicAndTimingStatisticsId relation Routine object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\RoutineQuery A secondary query class using the current class as primary query
     */
    public function useRoutineRelatedByPerformanceMusicAndTimingStatisticsIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoutineRelatedByPerformanceMusicAndTimingStatisticsId', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPerformanceStatistics $performanceStatistics Object to remove from the list of results
     *
     * @return $this|ChildPerformanceStatisticsQuery The current query, for fluid interface
     */
    public function prune($performanceStatistics = null)
    {
        if ($performanceStatistics) {
            $this->addUsingAlias(PerformanceStatisticsTableMap::COL_ID, $performanceStatistics->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_performance_statistics table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PerformanceStatisticsTableMap::clearInstancePool();
            PerformanceStatisticsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PerformanceStatisticsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PerformanceStatisticsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PerformanceStatisticsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PerformanceStatisticsQuery

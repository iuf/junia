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
use iuf\junia\model\Startgroup as ChildStartgroup;
use iuf\junia\model\StartgroupQuery as ChildStartgroupQuery;
use iuf\junia\model\Map\StartgroupTableMap;

/**
 * Base class that represents a query for the 'kk_junia_startgroup' table.
 *
 *
 *
 * @method     ChildStartgroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStartgroupQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildStartgroupQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method     ChildStartgroupQuery orderByCompetitionId($order = Criteria::ASC) Order by the competition_id column
 * @method     ChildStartgroupQuery orderByEventId($order = Criteria::ASC) Order by the event_id column
 * @method     ChildStartgroupQuery orderByPerformanceTotalStatisticId($order = Criteria::ASC) Order by the performance_total_statistic_id column
 * @method     ChildStartgroupQuery orderByPerformanceExecutionStatisticId($order = Criteria::ASC) Order by the performance_execution_statistic_id column
 * @method     ChildStartgroupQuery orderByPerformanceChoreographyStatisticId($order = Criteria::ASC) Order by the performance_choreography_statistic_id column
 * @method     ChildStartgroupQuery orderByPerformanceMusicAndTimingStatisticId($order = Criteria::ASC) Order by the performance_music_and_timing_statistic_id column
 *
 * @method     ChildStartgroupQuery groupById() Group by the id column
 * @method     ChildStartgroupQuery groupByName() Group by the name column
 * @method     ChildStartgroupQuery groupBySlug() Group by the slug column
 * @method     ChildStartgroupQuery groupByCompetitionId() Group by the competition_id column
 * @method     ChildStartgroupQuery groupByEventId() Group by the event_id column
 * @method     ChildStartgroupQuery groupByPerformanceTotalStatisticId() Group by the performance_total_statistic_id column
 * @method     ChildStartgroupQuery groupByPerformanceExecutionStatisticId() Group by the performance_execution_statistic_id column
 * @method     ChildStartgroupQuery groupByPerformanceChoreographyStatisticId() Group by the performance_choreography_statistic_id column
 * @method     ChildStartgroupQuery groupByPerformanceMusicAndTimingStatisticId() Group by the performance_music_and_timing_statistic_id column
 *
 * @method     ChildStartgroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStartgroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStartgroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStartgroupQuery leftJoinCompetition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Competition relation
 * @method     ChildStartgroupQuery rightJoinCompetition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Competition relation
 * @method     ChildStartgroupQuery innerJoinCompetition($relationAlias = null) Adds a INNER JOIN clause to the query using the Competition relation
 *
 * @method     ChildStartgroupQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildStartgroupQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildStartgroupQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildStartgroupQuery leftJoinPerformanceTotalStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceTotalStatistic relation
 * @method     ChildStartgroupQuery rightJoinPerformanceTotalStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceTotalStatistic relation
 * @method     ChildStartgroupQuery innerJoinPerformanceTotalStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceTotalStatistic relation
 *
 * @method     ChildStartgroupQuery leftJoinPerformanceExecutionStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceExecutionStatistic relation
 * @method     ChildStartgroupQuery rightJoinPerformanceExecutionStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceExecutionStatistic relation
 * @method     ChildStartgroupQuery innerJoinPerformanceExecutionStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceExecutionStatistic relation
 *
 * @method     ChildStartgroupQuery leftJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceChoreographyStatistic relation
 * @method     ChildStartgroupQuery rightJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceChoreographyStatistic relation
 * @method     ChildStartgroupQuery innerJoinPerformanceChoreographyStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceChoreographyStatistic relation
 *
 * @method     ChildStartgroupQuery leftJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a LEFT JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 * @method     ChildStartgroupQuery rightJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 * @method     ChildStartgroupQuery innerJoinPerformanceMusicAndTimingStatistic($relationAlias = null) Adds a INNER JOIN clause to the query using the PerformanceMusicAndTimingStatistic relation
 *
 * @method     ChildStartgroupQuery leftJoinRoutine($relationAlias = null) Adds a LEFT JOIN clause to the query using the Routine relation
 * @method     ChildStartgroupQuery rightJoinRoutine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Routine relation
 * @method     ChildStartgroupQuery innerJoinRoutine($relationAlias = null) Adds a INNER JOIN clause to the query using the Routine relation
 *
 * @method     ChildStartgroupQuery leftJoinJudge($relationAlias = null) Adds a LEFT JOIN clause to the query using the Judge relation
 * @method     ChildStartgroupQuery rightJoinJudge($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Judge relation
 * @method     ChildStartgroupQuery innerJoinJudge($relationAlias = null) Adds a INNER JOIN clause to the query using the Judge relation
 *
 * @method     \iuf\junia\model\CompetitionQuery|\iuf\junia\model\EventQuery|\iuf\junia\model\PerformanceStatisticQuery|\iuf\junia\model\RoutineQuery|\iuf\junia\model\JudgeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStartgroup findOne(ConnectionInterface $con = null) Return the first ChildStartgroup matching the query
 * @method     ChildStartgroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStartgroup matching the query, or a new ChildStartgroup object populated from the query conditions when no match is found
 *
 * @method     ChildStartgroup findOneById(int $id) Return the first ChildStartgroup filtered by the id column
 * @method     ChildStartgroup findOneByName(string $name) Return the first ChildStartgroup filtered by the name column
 * @method     ChildStartgroup findOneBySlug(string $slug) Return the first ChildStartgroup filtered by the slug column
 * @method     ChildStartgroup findOneByCompetitionId(int $competition_id) Return the first ChildStartgroup filtered by the competition_id column
 * @method     ChildStartgroup findOneByEventId(int $event_id) Return the first ChildStartgroup filtered by the event_id column
 * @method     ChildStartgroup findOneByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return the first ChildStartgroup filtered by the performance_total_statistic_id column
 * @method     ChildStartgroup findOneByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return the first ChildStartgroup filtered by the performance_execution_statistic_id column
 * @method     ChildStartgroup findOneByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return the first ChildStartgroup filtered by the performance_choreography_statistic_id column
 * @method     ChildStartgroup findOneByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return the first ChildStartgroup filtered by the performance_music_and_timing_statistic_id column *

 * @method     ChildStartgroup requirePk($key, ConnectionInterface $con = null) Return the ChildStartgroup by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOne(ConnectionInterface $con = null) Return the first ChildStartgroup matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStartgroup requireOneById(int $id) Return the first ChildStartgroup filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByName(string $name) Return the first ChildStartgroup filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneBySlug(string $slug) Return the first ChildStartgroup filtered by the slug column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByCompetitionId(int $competition_id) Return the first ChildStartgroup filtered by the competition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByEventId(int $event_id) Return the first ChildStartgroup filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return the first ChildStartgroup filtered by the performance_total_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return the first ChildStartgroup filtered by the performance_execution_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return the first ChildStartgroup filtered by the performance_choreography_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStartgroup requireOneByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return the first ChildStartgroup filtered by the performance_music_and_timing_statistic_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStartgroup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStartgroup objects based on current ModelCriteria
 * @method     ChildStartgroup[]|ObjectCollection findById(int $id) Return ChildStartgroup objects filtered by the id column
 * @method     ChildStartgroup[]|ObjectCollection findByName(string $name) Return ChildStartgroup objects filtered by the name column
 * @method     ChildStartgroup[]|ObjectCollection findBySlug(string $slug) Return ChildStartgroup objects filtered by the slug column
 * @method     ChildStartgroup[]|ObjectCollection findByCompetitionId(int $competition_id) Return ChildStartgroup objects filtered by the competition_id column
 * @method     ChildStartgroup[]|ObjectCollection findByEventId(int $event_id) Return ChildStartgroup objects filtered by the event_id column
 * @method     ChildStartgroup[]|ObjectCollection findByPerformanceTotalStatisticId(int $performance_total_statistic_id) Return ChildStartgroup objects filtered by the performance_total_statistic_id column
 * @method     ChildStartgroup[]|ObjectCollection findByPerformanceExecutionStatisticId(int $performance_execution_statistic_id) Return ChildStartgroup objects filtered by the performance_execution_statistic_id column
 * @method     ChildStartgroup[]|ObjectCollection findByPerformanceChoreographyStatisticId(int $performance_choreography_statistic_id) Return ChildStartgroup objects filtered by the performance_choreography_statistic_id column
 * @method     ChildStartgroup[]|ObjectCollection findByPerformanceMusicAndTimingStatisticId(int $performance_music_and_timing_statistic_id) Return ChildStartgroup objects filtered by the performance_music_and_timing_statistic_id column
 * @method     ChildStartgroup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StartgroupQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \iuf\junia\model\Base\StartgroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'keeko', $modelName = '\\iuf\\junia\\model\\Startgroup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStartgroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStartgroupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStartgroupQuery) {
            return $criteria;
        }
        $query = new ChildStartgroupQuery();
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
     * @return ChildStartgroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StartgroupTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StartgroupTableMap::DATABASE_NAME);
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
     * @return ChildStartgroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `name`, `slug`, `competition_id`, `event_id`, `performance_total_statistic_id`, `performance_execution_statistic_id`, `performance_choreography_statistic_id`, `performance_music_and_timing_statistic_id` FROM `kk_junia_startgroup` WHERE `id` = :p0';
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
            /** @var ChildStartgroup $obj */
            $obj = new ChildStartgroup();
            $obj->hydrate($row);
            StartgroupTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStartgroup|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StartgroupTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StartgroupTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StartgroupTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_SLUG, $slug, $comparison);
    }

    /**
     * Filter the query on the competition_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCompetitionId(1234); // WHERE competition_id = 1234
     * $query->filterByCompetitionId(array(12, 34)); // WHERE competition_id IN (12, 34)
     * $query->filterByCompetitionId(array('min' => 12)); // WHERE competition_id > 12
     * </code>
     *
     * @see       filterByCompetition()
     *
     * @param     mixed $competitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByCompetitionId($competitionId = null, $comparison = null)
    {
        if (is_array($competitionId)) {
            $useMinMax = false;
            if (isset($competitionId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_COMPETITION_ID, $competitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($competitionId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_COMPETITION_ID, $competitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_COMPETITION_ID, $competitionId, $comparison);
    }

    /**
     * Filter the query on the event_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEventId(1234); // WHERE event_id = 1234
     * $query->filterByEventId(array(12, 34)); // WHERE event_id IN (12, 34)
     * $query->filterByEventId(array('min' => 12)); // WHERE event_id > 12
     * </code>
     *
     * @see       filterByEvent()
     *
     * @param     mixed $eventId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByEventId($eventId = null, $comparison = null)
    {
        if (is_array($eventId)) {
            $useMinMax = false;
            if (isset($eventId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_EVENT_ID, $eventId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_EVENT_ID, $eventId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_EVENT_ID, $eventId, $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceTotalStatisticId($performanceTotalStatisticId = null, $comparison = null)
    {
        if (is_array($performanceTotalStatisticId)) {
            $useMinMax = false;
            if (isset($performanceTotalStatisticId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceTotalStatisticId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceTotalStatisticId, $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceExecutionStatisticId($performanceExecutionStatisticId = null, $comparison = null)
    {
        if (is_array($performanceExecutionStatisticId)) {
            $useMinMax = false;
            if (isset($performanceExecutionStatisticId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceExecutionStatisticId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceExecutionStatisticId, $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceChoreographyStatisticId($performanceChoreographyStatisticId = null, $comparison = null)
    {
        if (is_array($performanceChoreographyStatisticId)) {
            $useMinMax = false;
            if (isset($performanceChoreographyStatisticId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceChoreographyStatisticId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceChoreographyStatisticId, $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceMusicAndTimingStatisticId($performanceMusicAndTimingStatisticId = null, $comparison = null)
    {
        if (is_array($performanceMusicAndTimingStatisticId)) {
            $useMinMax = false;
            if (isset($performanceMusicAndTimingStatisticId['min'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($performanceMusicAndTimingStatisticId['max'])) {
                $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceMusicAndTimingStatisticId, $comparison);
    }

    /**
     * Filter the query by a related \iuf\junia\model\Competition object
     *
     * @param \iuf\junia\model\Competition|ObjectCollection $competition The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByCompetition($competition, $comparison = null)
    {
        if ($competition instanceof \iuf\junia\model\Competition) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_COMPETITION_ID, $competition->getId(), $comparison);
        } elseif ($competition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_COMPETITION_ID, $competition->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCompetition() only accepts arguments of type \iuf\junia\model\Competition or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Competition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function joinCompetition($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Competition');

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
            $this->addJoinObject($join, 'Competition');
        }

        return $this;
    }

    /**
     * Use the Competition relation Competition object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\CompetitionQuery A secondary query class using the current class as primary query
     */
    public function useCompetitionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompetition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Competition', '\iuf\junia\model\CompetitionQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Event object
     *
     * @param \iuf\junia\model\Event|ObjectCollection $event The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \iuf\junia\model\Event) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_EVENT_ID, $event->getId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_EVENT_ID, $event->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type \iuf\junia\model\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Event relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function joinEvent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Event');

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
            $this->addJoinObject($join, 'Event');
        }

        return $this;
    }

    /**
     * Use the Event relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \iuf\junia\model\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Event', '\iuf\junia\model\EventQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\PerformanceStatistic object
     *
     * @param \iuf\junia\model\PerformanceStatistic|ObjectCollection $performanceStatistic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceTotalStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
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
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceExecutionStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
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
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceChoreographyStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
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
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByPerformanceMusicAndTimingStatistic($performanceStatistic, $comparison = null)
    {
        if ($performanceStatistic instanceof \iuf\junia\model\PerformanceStatistic) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceStatistic->getId(), $comparison);
        } elseif ($performanceStatistic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $performanceStatistic->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
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
     * Filter the query by a related \iuf\junia\model\Routine object
     *
     * @param \iuf\junia\model\Routine|ObjectCollection $routine the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByRoutine($routine, $comparison = null)
    {
        if ($routine instanceof \iuf\junia\model\Routine) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_ID, $routine->getStartgroupId(), $comparison);
        } elseif ($routine instanceof ObjectCollection) {
            return $this
                ->useRoutineQuery()
                ->filterByPrimaryKeys($routine->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function joinRoutine($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useRoutineQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRoutine($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Routine', '\iuf\junia\model\RoutineQuery');
    }

    /**
     * Filter the query by a related \iuf\junia\model\Judge object
     *
     * @param \iuf\junia\model\Judge|ObjectCollection $judge the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStartgroupQuery The current query, for fluid interface
     */
    public function filterByJudge($judge, $comparison = null)
    {
        if ($judge instanceof \iuf\junia\model\Judge) {
            return $this
                ->addUsingAlias(StartgroupTableMap::COL_ID, $judge->getStartgroupId(), $comparison);
        } elseif ($judge instanceof ObjectCollection) {
            return $this
                ->useJudgeQuery()
                ->filterByPrimaryKeys($judge->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function joinJudge($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useJudgeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJudge($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Judge', '\iuf\junia\model\JudgeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStartgroup $startgroup Object to remove from the list of results
     *
     * @return $this|ChildStartgroupQuery The current query, for fluid interface
     */
    public function prune($startgroup = null)
    {
        if ($startgroup) {
            $this->addUsingAlias(StartgroupTableMap::COL_ID, $startgroup->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kk_junia_startgroup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StartgroupTableMap::clearInstancePool();
            StartgroupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StartgroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StartgroupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StartgroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StartgroupQuery

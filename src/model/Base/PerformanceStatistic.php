<?php

namespace iuf\junia\model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use iuf\junia\model\Event as ChildEvent;
use iuf\junia\model\EventQuery as ChildEventQuery;
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
use iuf\junia\model\Startgroup as ChildStartgroup;
use iuf\junia\model\StartgroupQuery as ChildStartgroupQuery;
use iuf\junia\model\Map\PerformanceStatisticTableMap;

/**
 * Base class that represents a row from the 'kk_junia_performance_statistic' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class PerformanceStatistic implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\iuf\\junia\\model\\Map\\PerformanceStatisticTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the min field.
     * @var        double
     */
    protected $min;

    /**
     * The value for the max field.
     * @var        double
     */
    protected $max;

    /**
     * The value for the range field.
     * @var        double
     */
    protected $range;

    /**
     * The value for the median field.
     * @var        double
     */
    protected $median;

    /**
     * The value for the average field.
     * @var        double
     */
    protected $average;

    /**
     * The value for the variance field.
     * @var        double
     */
    protected $variance;

    /**
     * The value for the standard_deviation field.
     * @var        double
     */
    protected $standard_deviation;

    /**
     * The value for the variability_coefficient field.
     * @var        double
     */
    protected $variability_coefficient;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEventsRelatedByPerformanceTotalStatisticId;
    protected $collEventsRelatedByPerformanceTotalStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEventsRelatedByPerformanceExecutionStatisticId;
    protected $collEventsRelatedByPerformanceExecutionStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEventsRelatedByPerformanceChoreographyStatisticId;
    protected $collEventsRelatedByPerformanceChoreographyStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEventsRelatedByPerformanceMusicAndTimingStatisticId;
    protected $collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildStartgroup[] Collection to store aggregation of ChildStartgroup objects.
     */
    protected $collStartgroupsRelatedByPerformanceTotalStatisticId;
    protected $collStartgroupsRelatedByPerformanceTotalStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildStartgroup[] Collection to store aggregation of ChildStartgroup objects.
     */
    protected $collStartgroupsRelatedByPerformanceExecutionStatisticId;
    protected $collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildStartgroup[] Collection to store aggregation of ChildStartgroup objects.
     */
    protected $collStartgroupsRelatedByPerformanceChoreographyStatisticId;
    protected $collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildStartgroup[] Collection to store aggregation of ChildStartgroup objects.
     */
    protected $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId;
    protected $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceTotalStatisticId;
    protected $collRoutinesRelatedByPerformanceTotalStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceExecutionStatisticId;
    protected $collRoutinesRelatedByPerformanceExecutionStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceChoreographyStatisticId;
    protected $collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceMusicAndTimingStatisticId;
    protected $collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStartgroup[]
     */
    protected $startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStartgroup[]
     */
    protected $startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStartgroup[]
     */
    protected $startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStartgroup[]
     */
    protected $startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;

    /**
     * Initializes internal state of iuf\junia\model\Base\PerformanceStatistic object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>PerformanceStatistic</code> instance.  If
     * <code>obj</code> is an instance of <code>PerformanceStatistic</code>, delegates to
     * <code>equals(PerformanceStatistic)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|PerformanceStatistic The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [min] column value.
     *
     * @return double
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Get the [max] column value.
     *
     * @return double
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Get the [range] column value.
     *
     * @return double
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Get the [median] column value.
     *
     * @return double
     */
    public function getMedian()
    {
        return $this->median;
    }

    /**
     * Get the [average] column value.
     *
     * @return double
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Get the [variance] column value.
     *
     * @return double
     */
    public function getVariance()
    {
        return $this->variance;
    }

    /**
     * Get the [standard_deviation] column value.
     *
     * @return double
     */
    public function getStandardDeviation()
    {
        return $this->standard_deviation;
    }

    /**
     * Get the [variability_coefficient] column value.
     *
     * @return double
     */
    public function getVariabilityCoefficient()
    {
        return $this->variability_coefficient;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [min] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setMin($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->min !== $v) {
            $this->min = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_MIN] = true;
        }

        return $this;
    } // setMin()

    /**
     * Set the value of [max] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setMax($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->max !== $v) {
            $this->max = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_MAX] = true;
        }

        return $this;
    } // setMax()

    /**
     * Set the value of [range] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setRange($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->range !== $v) {
            $this->range = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_RANGE] = true;
        }

        return $this;
    } // setRange()

    /**
     * Set the value of [median] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setMedian($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->median !== $v) {
            $this->median = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_MEDIAN] = true;
        }

        return $this;
    } // setMedian()

    /**
     * Set the value of [average] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setAverage($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->average !== $v) {
            $this->average = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_AVERAGE] = true;
        }

        return $this;
    } // setAverage()

    /**
     * Set the value of [variance] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setVariance($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->variance !== $v) {
            $this->variance = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_VARIANCE] = true;
        }

        return $this;
    } // setVariance()

    /**
     * Set the value of [standard_deviation] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setStandardDeviation($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->standard_deviation !== $v) {
            $this->standard_deviation = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_STANDARD_DEVIATION] = true;
        }

        return $this;
    } // setStandardDeviation()

    /**
     * Set the value of [variability_coefficient] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function setVariabilityCoefficient($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->variability_coefficient !== $v) {
            $this->variability_coefficient = $v;
            $this->modifiedColumns[PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT] = true;
        }

        return $this;
    } // setVariabilityCoefficient()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PerformanceStatisticTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PerformanceStatisticTableMap::translateFieldName('Min', TableMap::TYPE_PHPNAME, $indexType)];
            $this->min = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PerformanceStatisticTableMap::translateFieldName('Max', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PerformanceStatisticTableMap::translateFieldName('Range', TableMap::TYPE_PHPNAME, $indexType)];
            $this->range = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PerformanceStatisticTableMap::translateFieldName('Median', TableMap::TYPE_PHPNAME, $indexType)];
            $this->median = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PerformanceStatisticTableMap::translateFieldName('Average', TableMap::TYPE_PHPNAME, $indexType)];
            $this->average = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PerformanceStatisticTableMap::translateFieldName('Variance', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variance = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PerformanceStatisticTableMap::translateFieldName('StandardDeviation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->standard_deviation = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PerformanceStatisticTableMap::translateFieldName('VariabilityCoefficient', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variability_coefficient = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = PerformanceStatisticTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\iuf\\junia\\model\\PerformanceStatistic'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PerformanceStatisticTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPerformanceStatisticQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collEventsRelatedByPerformanceTotalStatisticId = null;

            $this->collEventsRelatedByPerformanceExecutionStatisticId = null;

            $this->collEventsRelatedByPerformanceChoreographyStatisticId = null;

            $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = null;

            $this->collStartgroupsRelatedByPerformanceTotalStatisticId = null;

            $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = null;

            $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = null;

            $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = null;

            $this->collRoutinesRelatedByPerformanceTotalStatisticId = null;

            $this->collRoutinesRelatedByPerformanceExecutionStatisticId = null;

            $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = null;

            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PerformanceStatistic::setDeleted()
     * @see PerformanceStatistic::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPerformanceStatisticQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PerformanceStatisticTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion !== null) {
                if (!$this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion as $eventRelatedByPerformanceTotalStatisticId) {
                        // need to save related object because we set the relation to null
                        $eventRelatedByPerformanceTotalStatisticId->save($con);
                    }
                    $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collEventsRelatedByPerformanceTotalStatisticId !== null) {
                foreach ($this->collEventsRelatedByPerformanceTotalStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion !== null) {
                if (!$this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion as $eventRelatedByPerformanceExecutionStatisticId) {
                        // need to save related object because we set the relation to null
                        $eventRelatedByPerformanceExecutionStatisticId->save($con);
                    }
                    $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collEventsRelatedByPerformanceExecutionStatisticId !== null) {
                foreach ($this->collEventsRelatedByPerformanceExecutionStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion !== null) {
                if (!$this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion as $eventRelatedByPerformanceChoreographyStatisticId) {
                        // need to save related object because we set the relation to null
                        $eventRelatedByPerformanceChoreographyStatisticId->save($con);
                    }
                    $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collEventsRelatedByPerformanceChoreographyStatisticId !== null) {
                foreach ($this->collEventsRelatedByPerformanceChoreographyStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion !== null) {
                if (!$this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion as $eventRelatedByPerformanceMusicAndTimingStatisticId) {
                        // need to save related object because we set the relation to null
                        $eventRelatedByPerformanceMusicAndTimingStatisticId->save($con);
                    }
                    $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId !== null) {
                foreach ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion !== null) {
                if (!$this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion as $startgroupRelatedByPerformanceTotalStatisticId) {
                        // need to save related object because we set the relation to null
                        $startgroupRelatedByPerformanceTotalStatisticId->save($con);
                    }
                    $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collStartgroupsRelatedByPerformanceTotalStatisticId !== null) {
                foreach ($this->collStartgroupsRelatedByPerformanceTotalStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion !== null) {
                if (!$this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion as $startgroupRelatedByPerformanceExecutionStatisticId) {
                        // need to save related object because we set the relation to null
                        $startgroupRelatedByPerformanceExecutionStatisticId->save($con);
                    }
                    $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId !== null) {
                foreach ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion !== null) {
                if (!$this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion as $startgroupRelatedByPerformanceChoreographyStatisticId) {
                        // need to save related object because we set the relation to null
                        $startgroupRelatedByPerformanceChoreographyStatisticId->save($con);
                    }
                    $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId !== null) {
                foreach ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion !== null) {
                if (!$this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion as $startgroupRelatedByPerformanceMusicAndTimingStatisticId) {
                        // need to save related object because we set the relation to null
                        $startgroupRelatedByPerformanceMusicAndTimingStatisticId->save($con);
                    }
                    $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId !== null) {
                foreach ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion as $routineRelatedByPerformanceTotalStatisticId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceTotalStatisticId->save($con);
                    }
                    $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceTotalStatisticId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion as $routineRelatedByPerformanceExecutionStatisticId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceExecutionStatisticId->save($con);
                    }
                    $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceExecutionStatisticId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion as $routineRelatedByPerformanceChoreographyStatisticId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceChoreographyStatisticId->save($con);
                    }
                    $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion as $routineRelatedByPerformanceMusicAndTimingStatisticId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceMusicAndTimingStatisticId->save($con);
                    }
                    $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PerformanceStatisticTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PerformanceStatisticTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MIN)) {
            $modifiedColumns[':p' . $index++]  = '`min`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MAX)) {
            $modifiedColumns[':p' . $index++]  = '`max`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_RANGE)) {
            $modifiedColumns[':p' . $index++]  = '`range`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MEDIAN)) {
            $modifiedColumns[':p' . $index++]  = '`median`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_AVERAGE)) {
            $modifiedColumns[':p' . $index++]  = '`average`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIANCE)) {
            $modifiedColumns[':p' . $index++]  = '`variance`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION)) {
            $modifiedColumns[':p' . $index++]  = '`standard_deviation`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT)) {
            $modifiedColumns[':p' . $index++]  = '`variability_coefficient`';
        }

        $sql = sprintf(
            'INSERT INTO `kk_junia_performance_statistic` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`min`':
                        $stmt->bindValue($identifier, $this->min, PDO::PARAM_STR);
                        break;
                    case '`max`':
                        $stmt->bindValue($identifier, $this->max, PDO::PARAM_STR);
                        break;
                    case '`range`':
                        $stmt->bindValue($identifier, $this->range, PDO::PARAM_STR);
                        break;
                    case '`median`':
                        $stmt->bindValue($identifier, $this->median, PDO::PARAM_STR);
                        break;
                    case '`average`':
                        $stmt->bindValue($identifier, $this->average, PDO::PARAM_STR);
                        break;
                    case '`variance`':
                        $stmt->bindValue($identifier, $this->variance, PDO::PARAM_STR);
                        break;
                    case '`standard_deviation`':
                        $stmt->bindValue($identifier, $this->standard_deviation, PDO::PARAM_STR);
                        break;
                    case '`variability_coefficient`':
                        $stmt->bindValue($identifier, $this->variability_coefficient, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PerformanceStatisticTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getMin();
                break;
            case 2:
                return $this->getMax();
                break;
            case 3:
                return $this->getRange();
                break;
            case 4:
                return $this->getMedian();
                break;
            case 5:
                return $this->getAverage();
                break;
            case 6:
                return $this->getVariance();
                break;
            case 7:
                return $this->getStandardDeviation();
                break;
            case 8:
                return $this->getVariabilityCoefficient();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['PerformanceStatistic'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PerformanceStatistic'][$this->hashCode()] = true;
        $keys = PerformanceStatisticTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getMin(),
            $keys[2] => $this->getMax(),
            $keys[3] => $this->getRange(),
            $keys[4] => $this->getMedian(),
            $keys[5] => $this->getAverage(),
            $keys[6] => $this->getVariance(),
            $keys[7] => $this->getStandardDeviation(),
            $keys[8] => $this->getVariabilityCoefficient(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collEventsRelatedByPerformanceTotalStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEventsRelatedByPerformanceTotalStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEventsRelatedByPerformanceExecutionStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEventsRelatedByPerformanceExecutionStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEventsRelatedByPerformanceChoreographyStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEventsRelatedByPerformanceChoreographyStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStartgroupsRelatedByPerformanceTotalStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'startgroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_startgroups';
                        break;
                    default:
                        $key = 'Startgroups';
                }

                $result[$key] = $this->collStartgroupsRelatedByPerformanceTotalStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStartgroupsRelatedByPerformanceExecutionStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'startgroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_startgroups';
                        break;
                    default:
                        $key = 'Startgroups';
                }

                $result[$key] = $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'startgroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_startgroups';
                        break;
                    default:
                        $key = 'Startgroups';
                }

                $result[$key] = $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'startgroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_startgroups';
                        break;
                    default:
                        $key = 'Startgroups';
                }

                $result[$key] = $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceTotalStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'routines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_routines';
                        break;
                    default:
                        $key = 'Routines';
                }

                $result[$key] = $this->collRoutinesRelatedByPerformanceTotalStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceExecutionStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'routines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_routines';
                        break;
                    default:
                        $key = 'Routines';
                }

                $result[$key] = $this->collRoutinesRelatedByPerformanceExecutionStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'routines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_routines';
                        break;
                    default:
                        $key = 'Routines';
                }

                $result[$key] = $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'routines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_routines';
                        break;
                    default:
                        $key = 'Routines';
                }

                $result[$key] = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\iuf\junia\model\PerformanceStatistic
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PerformanceStatisticTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\iuf\junia\model\PerformanceStatistic
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setMin($value);
                break;
            case 2:
                $this->setMax($value);
                break;
            case 3:
                $this->setRange($value);
                break;
            case 4:
                $this->setMedian($value);
                break;
            case 5:
                $this->setAverage($value);
                break;
            case 6:
                $this->setVariance($value);
                break;
            case 7:
                $this->setStandardDeviation($value);
                break;
            case 8:
                $this->setVariabilityCoefficient($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PerformanceStatisticTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMin($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMax($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setRange($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setMedian($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAverage($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setVariance($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setStandardDeviation($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVariabilityCoefficient($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PerformanceStatisticTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_ID)) {
            $criteria->add(PerformanceStatisticTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MIN)) {
            $criteria->add(PerformanceStatisticTableMap::COL_MIN, $this->min);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MAX)) {
            $criteria->add(PerformanceStatisticTableMap::COL_MAX, $this->max);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_RANGE)) {
            $criteria->add(PerformanceStatisticTableMap::COL_RANGE, $this->range);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_MEDIAN)) {
            $criteria->add(PerformanceStatisticTableMap::COL_MEDIAN, $this->median);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_AVERAGE)) {
            $criteria->add(PerformanceStatisticTableMap::COL_AVERAGE, $this->average);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIANCE)) {
            $criteria->add(PerformanceStatisticTableMap::COL_VARIANCE, $this->variance);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION)) {
            $criteria->add(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION, $this->standard_deviation);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT)) {
            $criteria->add(PerformanceStatisticTableMap::COL_VARIABILITY_COEFFICIENT, $this->variability_coefficient);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPerformanceStatisticQuery::create();
        $criteria->add(PerformanceStatisticTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \iuf\junia\model\PerformanceStatistic (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMin($this->getMin());
        $copyObj->setMax($this->getMax());
        $copyObj->setRange($this->getRange());
        $copyObj->setMedian($this->getMedian());
        $copyObj->setAverage($this->getAverage());
        $copyObj->setVariance($this->getVariance());
        $copyObj->setStandardDeviation($this->getStandardDeviation());
        $copyObj->setVariabilityCoefficient($this->getVariabilityCoefficient());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEventsRelatedByPerformanceTotalStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventRelatedByPerformanceTotalStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEventsRelatedByPerformanceExecutionStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventRelatedByPerformanceExecutionStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEventsRelatedByPerformanceChoreographyStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventRelatedByPerformanceChoreographyStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEventsRelatedByPerformanceMusicAndTimingStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventRelatedByPerformanceMusicAndTimingStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStartgroupsRelatedByPerformanceTotalStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStartgroupRelatedByPerformanceTotalStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStartgroupsRelatedByPerformanceExecutionStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStartgroupRelatedByPerformanceExecutionStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStartgroupsRelatedByPerformanceChoreographyStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStartgroupRelatedByPerformanceChoreographyStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStartgroupRelatedByPerformanceMusicAndTimingStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceTotalStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceTotalStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceExecutionStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceExecutionStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceChoreographyStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceChoreographyStatisticId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceMusicAndTimingStatisticId($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \iuf\junia\model\PerformanceStatistic Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('EventRelatedByPerformanceTotalStatisticId' == $relationName) {
            return $this->initEventsRelatedByPerformanceTotalStatisticId();
        }
        if ('EventRelatedByPerformanceExecutionStatisticId' == $relationName) {
            return $this->initEventsRelatedByPerformanceExecutionStatisticId();
        }
        if ('EventRelatedByPerformanceChoreographyStatisticId' == $relationName) {
            return $this->initEventsRelatedByPerformanceChoreographyStatisticId();
        }
        if ('EventRelatedByPerformanceMusicAndTimingStatisticId' == $relationName) {
            return $this->initEventsRelatedByPerformanceMusicAndTimingStatisticId();
        }
        if ('StartgroupRelatedByPerformanceTotalStatisticId' == $relationName) {
            return $this->initStartgroupsRelatedByPerformanceTotalStatisticId();
        }
        if ('StartgroupRelatedByPerformanceExecutionStatisticId' == $relationName) {
            return $this->initStartgroupsRelatedByPerformanceExecutionStatisticId();
        }
        if ('StartgroupRelatedByPerformanceChoreographyStatisticId' == $relationName) {
            return $this->initStartgroupsRelatedByPerformanceChoreographyStatisticId();
        }
        if ('StartgroupRelatedByPerformanceMusicAndTimingStatisticId' == $relationName) {
            return $this->initStartgroupsRelatedByPerformanceMusicAndTimingStatisticId();
        }
        if ('RoutineRelatedByPerformanceTotalStatisticId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceTotalStatisticId();
        }
        if ('RoutineRelatedByPerformanceExecutionStatisticId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceExecutionStatisticId();
        }
        if ('RoutineRelatedByPerformanceChoreographyStatisticId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceChoreographyStatisticId();
        }
        if ('RoutineRelatedByPerformanceMusicAndTimingStatisticId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticId();
        }
    }

    /**
     * Clears out the collEventsRelatedByPerformanceTotalStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventsRelatedByPerformanceTotalStatisticId()
     */
    public function clearEventsRelatedByPerformanceTotalStatisticId()
    {
        $this->collEventsRelatedByPerformanceTotalStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventsRelatedByPerformanceTotalStatisticId collection loaded partially.
     */
    public function resetPartialEventsRelatedByPerformanceTotalStatisticId($v = true)
    {
        $this->collEventsRelatedByPerformanceTotalStatisticIdPartial = $v;
    }

    /**
     * Initializes the collEventsRelatedByPerformanceTotalStatisticId collection.
     *
     * By default this just sets the collEventsRelatedByPerformanceTotalStatisticId collection to an empty array (like clearcollEventsRelatedByPerformanceTotalStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventsRelatedByPerformanceTotalStatisticId($overrideExisting = true)
    {
        if (null !== $this->collEventsRelatedByPerformanceTotalStatisticId && !$overrideExisting) {
            return;
        }
        $this->collEventsRelatedByPerformanceTotalStatisticId = new ObjectCollection();
        $this->collEventsRelatedByPerformanceTotalStatisticId->setModel('\iuf\junia\model\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEventsRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceTotalStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceTotalStatisticId) {
                // return empty collection
                $this->initEventsRelatedByPerformanceTotalStatisticId();
            } else {
                $collEventsRelatedByPerformanceTotalStatisticId = ChildEventQuery::create(null, $criteria)
                    ->filterByPerformanceTotalStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsRelatedByPerformanceTotalStatisticIdPartial && count($collEventsRelatedByPerformanceTotalStatisticId)) {
                        $this->initEventsRelatedByPerformanceTotalStatisticId(false);

                        foreach ($collEventsRelatedByPerformanceTotalStatisticId as $obj) {
                            if (false == $this->collEventsRelatedByPerformanceTotalStatisticId->contains($obj)) {
                                $this->collEventsRelatedByPerformanceTotalStatisticId->append($obj);
                            }
                        }

                        $this->collEventsRelatedByPerformanceTotalStatisticIdPartial = true;
                    }

                    return $collEventsRelatedByPerformanceTotalStatisticId;
                }

                if ($partial && $this->collEventsRelatedByPerformanceTotalStatisticId) {
                    foreach ($this->collEventsRelatedByPerformanceTotalStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collEventsRelatedByPerformanceTotalStatisticId[] = $obj;
                        }
                    }
                }

                $this->collEventsRelatedByPerformanceTotalStatisticId = $collEventsRelatedByPerformanceTotalStatisticId;
                $this->collEventsRelatedByPerformanceTotalStatisticIdPartial = false;
            }
        }

        return $this->collEventsRelatedByPerformanceTotalStatisticId;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventsRelatedByPerformanceTotalStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setEventsRelatedByPerformanceTotalStatisticId(Collection $eventsRelatedByPerformanceTotalStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsRelatedByPerformanceTotalStatisticIdToDelete */
        $eventsRelatedByPerformanceTotalStatisticIdToDelete = $this->getEventsRelatedByPerformanceTotalStatisticId(new Criteria(), $con)->diff($eventsRelatedByPerformanceTotalStatisticId);


        $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = $eventsRelatedByPerformanceTotalStatisticIdToDelete;

        foreach ($eventsRelatedByPerformanceTotalStatisticIdToDelete as $eventRelatedByPerformanceTotalStatisticIdRemoved) {
            $eventRelatedByPerformanceTotalStatisticIdRemoved->setPerformanceTotalStatistic(null);
        }

        $this->collEventsRelatedByPerformanceTotalStatisticId = null;
        foreach ($eventsRelatedByPerformanceTotalStatisticId as $eventRelatedByPerformanceTotalStatisticId) {
            $this->addEventRelatedByPerformanceTotalStatisticId($eventRelatedByPerformanceTotalStatisticId);
        }

        $this->collEventsRelatedByPerformanceTotalStatisticId = $eventsRelatedByPerformanceTotalStatisticId;
        $this->collEventsRelatedByPerformanceTotalStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEventsRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceTotalStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceTotalStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventsRelatedByPerformanceTotalStatisticId());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceTotalStatistic($this)
                ->count($con);
        }

        return count($this->collEventsRelatedByPerformanceTotalStatisticId);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addEventRelatedByPerformanceTotalStatisticId(ChildEvent $l)
    {
        if ($this->collEventsRelatedByPerformanceTotalStatisticId === null) {
            $this->initEventsRelatedByPerformanceTotalStatisticId();
            $this->collEventsRelatedByPerformanceTotalStatisticIdPartial = true;
        }

        if (!$this->collEventsRelatedByPerformanceTotalStatisticId->contains($l)) {
            $this->doAddEventRelatedByPerformanceTotalStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildEvent $eventRelatedByPerformanceTotalStatisticId The ChildEvent object to add.
     */
    protected function doAddEventRelatedByPerformanceTotalStatisticId(ChildEvent $eventRelatedByPerformanceTotalStatisticId)
    {
        $this->collEventsRelatedByPerformanceTotalStatisticId[]= $eventRelatedByPerformanceTotalStatisticId;
        $eventRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic($this);
    }

    /**
     * @param  ChildEvent $eventRelatedByPerformanceTotalStatisticId The ChildEvent object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeEventRelatedByPerformanceTotalStatisticId(ChildEvent $eventRelatedByPerformanceTotalStatisticId)
    {
        if ($this->getEventsRelatedByPerformanceTotalStatisticId()->contains($eventRelatedByPerformanceTotalStatisticId)) {
            $pos = $this->collEventsRelatedByPerformanceTotalStatisticId->search($eventRelatedByPerformanceTotalStatisticId);
            $this->collEventsRelatedByPerformanceTotalStatisticId->remove($pos);
            if (null === $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion) {
                $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = clone $this->collEventsRelatedByPerformanceTotalStatisticId;
                $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion->clear();
            }
            $this->eventsRelatedByPerformanceTotalStatisticIdScheduledForDeletion[]= $eventRelatedByPerformanceTotalStatisticId;
            $eventRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic(null);
        }

        return $this;
    }

    /**
     * Clears out the collEventsRelatedByPerformanceExecutionStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventsRelatedByPerformanceExecutionStatisticId()
     */
    public function clearEventsRelatedByPerformanceExecutionStatisticId()
    {
        $this->collEventsRelatedByPerformanceExecutionStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventsRelatedByPerformanceExecutionStatisticId collection loaded partially.
     */
    public function resetPartialEventsRelatedByPerformanceExecutionStatisticId($v = true)
    {
        $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial = $v;
    }

    /**
     * Initializes the collEventsRelatedByPerformanceExecutionStatisticId collection.
     *
     * By default this just sets the collEventsRelatedByPerformanceExecutionStatisticId collection to an empty array (like clearcollEventsRelatedByPerformanceExecutionStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventsRelatedByPerformanceExecutionStatisticId($overrideExisting = true)
    {
        if (null !== $this->collEventsRelatedByPerformanceExecutionStatisticId && !$overrideExisting) {
            return;
        }
        $this->collEventsRelatedByPerformanceExecutionStatisticId = new ObjectCollection();
        $this->collEventsRelatedByPerformanceExecutionStatisticId->setModel('\iuf\junia\model\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEventsRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceExecutionStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceExecutionStatisticId) {
                // return empty collection
                $this->initEventsRelatedByPerformanceExecutionStatisticId();
            } else {
                $collEventsRelatedByPerformanceExecutionStatisticId = ChildEventQuery::create(null, $criteria)
                    ->filterByPerformanceExecutionStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial && count($collEventsRelatedByPerformanceExecutionStatisticId)) {
                        $this->initEventsRelatedByPerformanceExecutionStatisticId(false);

                        foreach ($collEventsRelatedByPerformanceExecutionStatisticId as $obj) {
                            if (false == $this->collEventsRelatedByPerformanceExecutionStatisticId->contains($obj)) {
                                $this->collEventsRelatedByPerformanceExecutionStatisticId->append($obj);
                            }
                        }

                        $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial = true;
                    }

                    return $collEventsRelatedByPerformanceExecutionStatisticId;
                }

                if ($partial && $this->collEventsRelatedByPerformanceExecutionStatisticId) {
                    foreach ($this->collEventsRelatedByPerformanceExecutionStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collEventsRelatedByPerformanceExecutionStatisticId[] = $obj;
                        }
                    }
                }

                $this->collEventsRelatedByPerformanceExecutionStatisticId = $collEventsRelatedByPerformanceExecutionStatisticId;
                $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial = false;
            }
        }

        return $this->collEventsRelatedByPerformanceExecutionStatisticId;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventsRelatedByPerformanceExecutionStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setEventsRelatedByPerformanceExecutionStatisticId(Collection $eventsRelatedByPerformanceExecutionStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsRelatedByPerformanceExecutionStatisticIdToDelete */
        $eventsRelatedByPerformanceExecutionStatisticIdToDelete = $this->getEventsRelatedByPerformanceExecutionStatisticId(new Criteria(), $con)->diff($eventsRelatedByPerformanceExecutionStatisticId);


        $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = $eventsRelatedByPerformanceExecutionStatisticIdToDelete;

        foreach ($eventsRelatedByPerformanceExecutionStatisticIdToDelete as $eventRelatedByPerformanceExecutionStatisticIdRemoved) {
            $eventRelatedByPerformanceExecutionStatisticIdRemoved->setPerformanceExecutionStatistic(null);
        }

        $this->collEventsRelatedByPerformanceExecutionStatisticId = null;
        foreach ($eventsRelatedByPerformanceExecutionStatisticId as $eventRelatedByPerformanceExecutionStatisticId) {
            $this->addEventRelatedByPerformanceExecutionStatisticId($eventRelatedByPerformanceExecutionStatisticId);
        }

        $this->collEventsRelatedByPerformanceExecutionStatisticId = $eventsRelatedByPerformanceExecutionStatisticId;
        $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEventsRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceExecutionStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceExecutionStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventsRelatedByPerformanceExecutionStatisticId());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceExecutionStatistic($this)
                ->count($con);
        }

        return count($this->collEventsRelatedByPerformanceExecutionStatisticId);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addEventRelatedByPerformanceExecutionStatisticId(ChildEvent $l)
    {
        if ($this->collEventsRelatedByPerformanceExecutionStatisticId === null) {
            $this->initEventsRelatedByPerformanceExecutionStatisticId();
            $this->collEventsRelatedByPerformanceExecutionStatisticIdPartial = true;
        }

        if (!$this->collEventsRelatedByPerformanceExecutionStatisticId->contains($l)) {
            $this->doAddEventRelatedByPerformanceExecutionStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildEvent $eventRelatedByPerformanceExecutionStatisticId The ChildEvent object to add.
     */
    protected function doAddEventRelatedByPerformanceExecutionStatisticId(ChildEvent $eventRelatedByPerformanceExecutionStatisticId)
    {
        $this->collEventsRelatedByPerformanceExecutionStatisticId[]= $eventRelatedByPerformanceExecutionStatisticId;
        $eventRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic($this);
    }

    /**
     * @param  ChildEvent $eventRelatedByPerformanceExecutionStatisticId The ChildEvent object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeEventRelatedByPerformanceExecutionStatisticId(ChildEvent $eventRelatedByPerformanceExecutionStatisticId)
    {
        if ($this->getEventsRelatedByPerformanceExecutionStatisticId()->contains($eventRelatedByPerformanceExecutionStatisticId)) {
            $pos = $this->collEventsRelatedByPerformanceExecutionStatisticId->search($eventRelatedByPerformanceExecutionStatisticId);
            $this->collEventsRelatedByPerformanceExecutionStatisticId->remove($pos);
            if (null === $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion) {
                $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = clone $this->collEventsRelatedByPerformanceExecutionStatisticId;
                $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->clear();
            }
            $this->eventsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion[]= $eventRelatedByPerformanceExecutionStatisticId;
            $eventRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic(null);
        }

        return $this;
    }

    /**
     * Clears out the collEventsRelatedByPerformanceChoreographyStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventsRelatedByPerformanceChoreographyStatisticId()
     */
    public function clearEventsRelatedByPerformanceChoreographyStatisticId()
    {
        $this->collEventsRelatedByPerformanceChoreographyStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventsRelatedByPerformanceChoreographyStatisticId collection loaded partially.
     */
    public function resetPartialEventsRelatedByPerformanceChoreographyStatisticId($v = true)
    {
        $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial = $v;
    }

    /**
     * Initializes the collEventsRelatedByPerformanceChoreographyStatisticId collection.
     *
     * By default this just sets the collEventsRelatedByPerformanceChoreographyStatisticId collection to an empty array (like clearcollEventsRelatedByPerformanceChoreographyStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventsRelatedByPerformanceChoreographyStatisticId($overrideExisting = true)
    {
        if (null !== $this->collEventsRelatedByPerformanceChoreographyStatisticId && !$overrideExisting) {
            return;
        }
        $this->collEventsRelatedByPerformanceChoreographyStatisticId = new ObjectCollection();
        $this->collEventsRelatedByPerformanceChoreographyStatisticId->setModel('\iuf\junia\model\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEventsRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceChoreographyStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceChoreographyStatisticId) {
                // return empty collection
                $this->initEventsRelatedByPerformanceChoreographyStatisticId();
            } else {
                $collEventsRelatedByPerformanceChoreographyStatisticId = ChildEventQuery::create(null, $criteria)
                    ->filterByPerformanceChoreographyStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial && count($collEventsRelatedByPerformanceChoreographyStatisticId)) {
                        $this->initEventsRelatedByPerformanceChoreographyStatisticId(false);

                        foreach ($collEventsRelatedByPerformanceChoreographyStatisticId as $obj) {
                            if (false == $this->collEventsRelatedByPerformanceChoreographyStatisticId->contains($obj)) {
                                $this->collEventsRelatedByPerformanceChoreographyStatisticId->append($obj);
                            }
                        }

                        $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial = true;
                    }

                    return $collEventsRelatedByPerformanceChoreographyStatisticId;
                }

                if ($partial && $this->collEventsRelatedByPerformanceChoreographyStatisticId) {
                    foreach ($this->collEventsRelatedByPerformanceChoreographyStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collEventsRelatedByPerformanceChoreographyStatisticId[] = $obj;
                        }
                    }
                }

                $this->collEventsRelatedByPerformanceChoreographyStatisticId = $collEventsRelatedByPerformanceChoreographyStatisticId;
                $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial = false;
            }
        }

        return $this->collEventsRelatedByPerformanceChoreographyStatisticId;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventsRelatedByPerformanceChoreographyStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setEventsRelatedByPerformanceChoreographyStatisticId(Collection $eventsRelatedByPerformanceChoreographyStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsRelatedByPerformanceChoreographyStatisticIdToDelete */
        $eventsRelatedByPerformanceChoreographyStatisticIdToDelete = $this->getEventsRelatedByPerformanceChoreographyStatisticId(new Criteria(), $con)->diff($eventsRelatedByPerformanceChoreographyStatisticId);


        $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = $eventsRelatedByPerformanceChoreographyStatisticIdToDelete;

        foreach ($eventsRelatedByPerformanceChoreographyStatisticIdToDelete as $eventRelatedByPerformanceChoreographyStatisticIdRemoved) {
            $eventRelatedByPerformanceChoreographyStatisticIdRemoved->setPerformanceChoreographyStatistic(null);
        }

        $this->collEventsRelatedByPerformanceChoreographyStatisticId = null;
        foreach ($eventsRelatedByPerformanceChoreographyStatisticId as $eventRelatedByPerformanceChoreographyStatisticId) {
            $this->addEventRelatedByPerformanceChoreographyStatisticId($eventRelatedByPerformanceChoreographyStatisticId);
        }

        $this->collEventsRelatedByPerformanceChoreographyStatisticId = $eventsRelatedByPerformanceChoreographyStatisticId;
        $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEventsRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceChoreographyStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceChoreographyStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventsRelatedByPerformanceChoreographyStatisticId());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceChoreographyStatistic($this)
                ->count($con);
        }

        return count($this->collEventsRelatedByPerformanceChoreographyStatisticId);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addEventRelatedByPerformanceChoreographyStatisticId(ChildEvent $l)
    {
        if ($this->collEventsRelatedByPerformanceChoreographyStatisticId === null) {
            $this->initEventsRelatedByPerformanceChoreographyStatisticId();
            $this->collEventsRelatedByPerformanceChoreographyStatisticIdPartial = true;
        }

        if (!$this->collEventsRelatedByPerformanceChoreographyStatisticId->contains($l)) {
            $this->doAddEventRelatedByPerformanceChoreographyStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildEvent $eventRelatedByPerformanceChoreographyStatisticId The ChildEvent object to add.
     */
    protected function doAddEventRelatedByPerformanceChoreographyStatisticId(ChildEvent $eventRelatedByPerformanceChoreographyStatisticId)
    {
        $this->collEventsRelatedByPerformanceChoreographyStatisticId[]= $eventRelatedByPerformanceChoreographyStatisticId;
        $eventRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic($this);
    }

    /**
     * @param  ChildEvent $eventRelatedByPerformanceChoreographyStatisticId The ChildEvent object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeEventRelatedByPerformanceChoreographyStatisticId(ChildEvent $eventRelatedByPerformanceChoreographyStatisticId)
    {
        if ($this->getEventsRelatedByPerformanceChoreographyStatisticId()->contains($eventRelatedByPerformanceChoreographyStatisticId)) {
            $pos = $this->collEventsRelatedByPerformanceChoreographyStatisticId->search($eventRelatedByPerformanceChoreographyStatisticId);
            $this->collEventsRelatedByPerformanceChoreographyStatisticId->remove($pos);
            if (null === $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion) {
                $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = clone $this->collEventsRelatedByPerformanceChoreographyStatisticId;
                $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->clear();
            }
            $this->eventsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion[]= $eventRelatedByPerformanceChoreographyStatisticId;
            $eventRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic(null);
        }

        return $this;
    }

    /**
     * Clears out the collEventsRelatedByPerformanceMusicAndTimingStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventsRelatedByPerformanceMusicAndTimingStatisticId()
     */
    public function clearEventsRelatedByPerformanceMusicAndTimingStatisticId()
    {
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventsRelatedByPerformanceMusicAndTimingStatisticId collection loaded partially.
     */
    public function resetPartialEventsRelatedByPerformanceMusicAndTimingStatisticId($v = true)
    {
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial = $v;
    }

    /**
     * Initializes the collEventsRelatedByPerformanceMusicAndTimingStatisticId collection.
     *
     * By default this just sets the collEventsRelatedByPerformanceMusicAndTimingStatisticId collection to an empty array (like clearcollEventsRelatedByPerformanceMusicAndTimingStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventsRelatedByPerformanceMusicAndTimingStatisticId($overrideExisting = true)
    {
        if (null !== $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId && !$overrideExisting) {
            return;
        }
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = new ObjectCollection();
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->setModel('\iuf\junia\model\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEventsRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId) {
                // return empty collection
                $this->initEventsRelatedByPerformanceMusicAndTimingStatisticId();
            } else {
                $collEventsRelatedByPerformanceMusicAndTimingStatisticId = ChildEventQuery::create(null, $criteria)
                    ->filterByPerformanceMusicAndTimingStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial && count($collEventsRelatedByPerformanceMusicAndTimingStatisticId)) {
                        $this->initEventsRelatedByPerformanceMusicAndTimingStatisticId(false);

                        foreach ($collEventsRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                            if (false == $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->contains($obj)) {
                                $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->append($obj);
                            }
                        }

                        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
                    }

                    return $collEventsRelatedByPerformanceMusicAndTimingStatisticId;
                }

                if ($partial && $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId) {
                    foreach ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collEventsRelatedByPerformanceMusicAndTimingStatisticId[] = $obj;
                        }
                    }
                }

                $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = $collEventsRelatedByPerformanceMusicAndTimingStatisticId;
                $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;
            }
        }

        return $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventsRelatedByPerformanceMusicAndTimingStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setEventsRelatedByPerformanceMusicAndTimingStatisticId(Collection $eventsRelatedByPerformanceMusicAndTimingStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsRelatedByPerformanceMusicAndTimingStatisticIdToDelete */
        $eventsRelatedByPerformanceMusicAndTimingStatisticIdToDelete = $this->getEventsRelatedByPerformanceMusicAndTimingStatisticId(new Criteria(), $con)->diff($eventsRelatedByPerformanceMusicAndTimingStatisticId);


        $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = $eventsRelatedByPerformanceMusicAndTimingStatisticIdToDelete;

        foreach ($eventsRelatedByPerformanceMusicAndTimingStatisticIdToDelete as $eventRelatedByPerformanceMusicAndTimingStatisticIdRemoved) {
            $eventRelatedByPerformanceMusicAndTimingStatisticIdRemoved->setPerformanceMusicAndTimingStatistic(null);
        }

        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = null;
        foreach ($eventsRelatedByPerformanceMusicAndTimingStatisticId as $eventRelatedByPerformanceMusicAndTimingStatisticId) {
            $this->addEventRelatedByPerformanceMusicAndTimingStatisticId($eventRelatedByPerformanceMusicAndTimingStatisticId);
        }

        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = $eventsRelatedByPerformanceMusicAndTimingStatisticId;
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEventsRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventsRelatedByPerformanceMusicAndTimingStatisticId());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceMusicAndTimingStatistic($this)
                ->count($con);
        }

        return count($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addEventRelatedByPerformanceMusicAndTimingStatisticId(ChildEvent $l)
    {
        if ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId === null) {
            $this->initEventsRelatedByPerformanceMusicAndTimingStatisticId();
            $this->collEventsRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
        }

        if (!$this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->contains($l)) {
            $this->doAddEventRelatedByPerformanceMusicAndTimingStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildEvent $eventRelatedByPerformanceMusicAndTimingStatisticId The ChildEvent object to add.
     */
    protected function doAddEventRelatedByPerformanceMusicAndTimingStatisticId(ChildEvent $eventRelatedByPerformanceMusicAndTimingStatisticId)
    {
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId[]= $eventRelatedByPerformanceMusicAndTimingStatisticId;
        $eventRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic($this);
    }

    /**
     * @param  ChildEvent $eventRelatedByPerformanceMusicAndTimingStatisticId The ChildEvent object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeEventRelatedByPerformanceMusicAndTimingStatisticId(ChildEvent $eventRelatedByPerformanceMusicAndTimingStatisticId)
    {
        if ($this->getEventsRelatedByPerformanceMusicAndTimingStatisticId()->contains($eventRelatedByPerformanceMusicAndTimingStatisticId)) {
            $pos = $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->search($eventRelatedByPerformanceMusicAndTimingStatisticId);
            $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId->remove($pos);
            if (null === $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion) {
                $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = clone $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId;
                $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->clear();
            }
            $this->eventsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion[]= $eventRelatedByPerformanceMusicAndTimingStatisticId;
            $eventRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic(null);
        }

        return $this;
    }

    /**
     * Clears out the collStartgroupsRelatedByPerformanceTotalStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStartgroupsRelatedByPerformanceTotalStatisticId()
     */
    public function clearStartgroupsRelatedByPerformanceTotalStatisticId()
    {
        $this->collStartgroupsRelatedByPerformanceTotalStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStartgroupsRelatedByPerformanceTotalStatisticId collection loaded partially.
     */
    public function resetPartialStartgroupsRelatedByPerformanceTotalStatisticId($v = true)
    {
        $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial = $v;
    }

    /**
     * Initializes the collStartgroupsRelatedByPerformanceTotalStatisticId collection.
     *
     * By default this just sets the collStartgroupsRelatedByPerformanceTotalStatisticId collection to an empty array (like clearcollStartgroupsRelatedByPerformanceTotalStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStartgroupsRelatedByPerformanceTotalStatisticId($overrideExisting = true)
    {
        if (null !== $this->collStartgroupsRelatedByPerformanceTotalStatisticId && !$overrideExisting) {
            return;
        }
        $this->collStartgroupsRelatedByPerformanceTotalStatisticId = new ObjectCollection();
        $this->collStartgroupsRelatedByPerformanceTotalStatisticId->setModel('\iuf\junia\model\Startgroup');
    }

    /**
     * Gets an array of ChildStartgroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     * @throws PropelException
     */
    public function getStartgroupsRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceTotalStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceTotalStatisticId) {
                // return empty collection
                $this->initStartgroupsRelatedByPerformanceTotalStatisticId();
            } else {
                $collStartgroupsRelatedByPerformanceTotalStatisticId = ChildStartgroupQuery::create(null, $criteria)
                    ->filterByPerformanceTotalStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial && count($collStartgroupsRelatedByPerformanceTotalStatisticId)) {
                        $this->initStartgroupsRelatedByPerformanceTotalStatisticId(false);

                        foreach ($collStartgroupsRelatedByPerformanceTotalStatisticId as $obj) {
                            if (false == $this->collStartgroupsRelatedByPerformanceTotalStatisticId->contains($obj)) {
                                $this->collStartgroupsRelatedByPerformanceTotalStatisticId->append($obj);
                            }
                        }

                        $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial = true;
                    }

                    return $collStartgroupsRelatedByPerformanceTotalStatisticId;
                }

                if ($partial && $this->collStartgroupsRelatedByPerformanceTotalStatisticId) {
                    foreach ($this->collStartgroupsRelatedByPerformanceTotalStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collStartgroupsRelatedByPerformanceTotalStatisticId[] = $obj;
                        }
                    }
                }

                $this->collStartgroupsRelatedByPerformanceTotalStatisticId = $collStartgroupsRelatedByPerformanceTotalStatisticId;
                $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial = false;
            }
        }

        return $this->collStartgroupsRelatedByPerformanceTotalStatisticId;
    }

    /**
     * Sets a collection of ChildStartgroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $startgroupsRelatedByPerformanceTotalStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setStartgroupsRelatedByPerformanceTotalStatisticId(Collection $startgroupsRelatedByPerformanceTotalStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildStartgroup[] $startgroupsRelatedByPerformanceTotalStatisticIdToDelete */
        $startgroupsRelatedByPerformanceTotalStatisticIdToDelete = $this->getStartgroupsRelatedByPerformanceTotalStatisticId(new Criteria(), $con)->diff($startgroupsRelatedByPerformanceTotalStatisticId);


        $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = $startgroupsRelatedByPerformanceTotalStatisticIdToDelete;

        foreach ($startgroupsRelatedByPerformanceTotalStatisticIdToDelete as $startgroupRelatedByPerformanceTotalStatisticIdRemoved) {
            $startgroupRelatedByPerformanceTotalStatisticIdRemoved->setPerformanceTotalStatistic(null);
        }

        $this->collStartgroupsRelatedByPerformanceTotalStatisticId = null;
        foreach ($startgroupsRelatedByPerformanceTotalStatisticId as $startgroupRelatedByPerformanceTotalStatisticId) {
            $this->addStartgroupRelatedByPerformanceTotalStatisticId($startgroupRelatedByPerformanceTotalStatisticId);
        }

        $this->collStartgroupsRelatedByPerformanceTotalStatisticId = $startgroupsRelatedByPerformanceTotalStatisticId;
        $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Startgroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Startgroup objects.
     * @throws PropelException
     */
    public function countStartgroupsRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceTotalStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceTotalStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStartgroupsRelatedByPerformanceTotalStatisticId());
            }

            $query = ChildStartgroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceTotalStatistic($this)
                ->count($con);
        }

        return count($this->collStartgroupsRelatedByPerformanceTotalStatisticId);
    }

    /**
     * Method called to associate a ChildStartgroup object to this object
     * through the ChildStartgroup foreign key attribute.
     *
     * @param  ChildStartgroup $l ChildStartgroup
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addStartgroupRelatedByPerformanceTotalStatisticId(ChildStartgroup $l)
    {
        if ($this->collStartgroupsRelatedByPerformanceTotalStatisticId === null) {
            $this->initStartgroupsRelatedByPerformanceTotalStatisticId();
            $this->collStartgroupsRelatedByPerformanceTotalStatisticIdPartial = true;
        }

        if (!$this->collStartgroupsRelatedByPerformanceTotalStatisticId->contains($l)) {
            $this->doAddStartgroupRelatedByPerformanceTotalStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildStartgroup $startgroupRelatedByPerformanceTotalStatisticId The ChildStartgroup object to add.
     */
    protected function doAddStartgroupRelatedByPerformanceTotalStatisticId(ChildStartgroup $startgroupRelatedByPerformanceTotalStatisticId)
    {
        $this->collStartgroupsRelatedByPerformanceTotalStatisticId[]= $startgroupRelatedByPerformanceTotalStatisticId;
        $startgroupRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic($this);
    }

    /**
     * @param  ChildStartgroup $startgroupRelatedByPerformanceTotalStatisticId The ChildStartgroup object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeStartgroupRelatedByPerformanceTotalStatisticId(ChildStartgroup $startgroupRelatedByPerformanceTotalStatisticId)
    {
        if ($this->getStartgroupsRelatedByPerformanceTotalStatisticId()->contains($startgroupRelatedByPerformanceTotalStatisticId)) {
            $pos = $this->collStartgroupsRelatedByPerformanceTotalStatisticId->search($startgroupRelatedByPerformanceTotalStatisticId);
            $this->collStartgroupsRelatedByPerformanceTotalStatisticId->remove($pos);
            if (null === $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion) {
                $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion = clone $this->collStartgroupsRelatedByPerformanceTotalStatisticId;
                $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion->clear();
            }
            $this->startgroupsRelatedByPerformanceTotalStatisticIdScheduledForDeletion[]= $startgroupRelatedByPerformanceTotalStatisticId;
            $startgroupRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceTotalStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceTotalStatisticIdJoinCompetition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Competition', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceTotalStatisticId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceTotalStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceTotalStatisticIdJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceTotalStatisticId($query, $con);
    }

    /**
     * Clears out the collStartgroupsRelatedByPerformanceExecutionStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStartgroupsRelatedByPerformanceExecutionStatisticId()
     */
    public function clearStartgroupsRelatedByPerformanceExecutionStatisticId()
    {
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStartgroupsRelatedByPerformanceExecutionStatisticId collection loaded partially.
     */
    public function resetPartialStartgroupsRelatedByPerformanceExecutionStatisticId($v = true)
    {
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial = $v;
    }

    /**
     * Initializes the collStartgroupsRelatedByPerformanceExecutionStatisticId collection.
     *
     * By default this just sets the collStartgroupsRelatedByPerformanceExecutionStatisticId collection to an empty array (like clearcollStartgroupsRelatedByPerformanceExecutionStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStartgroupsRelatedByPerformanceExecutionStatisticId($overrideExisting = true)
    {
        if (null !== $this->collStartgroupsRelatedByPerformanceExecutionStatisticId && !$overrideExisting) {
            return;
        }
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = new ObjectCollection();
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->setModel('\iuf\junia\model\Startgroup');
    }

    /**
     * Gets an array of ChildStartgroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     * @throws PropelException
     */
    public function getStartgroupsRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceExecutionStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceExecutionStatisticId) {
                // return empty collection
                $this->initStartgroupsRelatedByPerformanceExecutionStatisticId();
            } else {
                $collStartgroupsRelatedByPerformanceExecutionStatisticId = ChildStartgroupQuery::create(null, $criteria)
                    ->filterByPerformanceExecutionStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial && count($collStartgroupsRelatedByPerformanceExecutionStatisticId)) {
                        $this->initStartgroupsRelatedByPerformanceExecutionStatisticId(false);

                        foreach ($collStartgroupsRelatedByPerformanceExecutionStatisticId as $obj) {
                            if (false == $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->contains($obj)) {
                                $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->append($obj);
                            }
                        }

                        $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial = true;
                    }

                    return $collStartgroupsRelatedByPerformanceExecutionStatisticId;
                }

                if ($partial && $this->collStartgroupsRelatedByPerformanceExecutionStatisticId) {
                    foreach ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collStartgroupsRelatedByPerformanceExecutionStatisticId[] = $obj;
                        }
                    }
                }

                $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = $collStartgroupsRelatedByPerformanceExecutionStatisticId;
                $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial = false;
            }
        }

        return $this->collStartgroupsRelatedByPerformanceExecutionStatisticId;
    }

    /**
     * Sets a collection of ChildStartgroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $startgroupsRelatedByPerformanceExecutionStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setStartgroupsRelatedByPerformanceExecutionStatisticId(Collection $startgroupsRelatedByPerformanceExecutionStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildStartgroup[] $startgroupsRelatedByPerformanceExecutionStatisticIdToDelete */
        $startgroupsRelatedByPerformanceExecutionStatisticIdToDelete = $this->getStartgroupsRelatedByPerformanceExecutionStatisticId(new Criteria(), $con)->diff($startgroupsRelatedByPerformanceExecutionStatisticId);


        $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = $startgroupsRelatedByPerformanceExecutionStatisticIdToDelete;

        foreach ($startgroupsRelatedByPerformanceExecutionStatisticIdToDelete as $startgroupRelatedByPerformanceExecutionStatisticIdRemoved) {
            $startgroupRelatedByPerformanceExecutionStatisticIdRemoved->setPerformanceExecutionStatistic(null);
        }

        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = null;
        foreach ($startgroupsRelatedByPerformanceExecutionStatisticId as $startgroupRelatedByPerformanceExecutionStatisticId) {
            $this->addStartgroupRelatedByPerformanceExecutionStatisticId($startgroupRelatedByPerformanceExecutionStatisticId);
        }

        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = $startgroupsRelatedByPerformanceExecutionStatisticId;
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Startgroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Startgroup objects.
     * @throws PropelException
     */
    public function countStartgroupsRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceExecutionStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceExecutionStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStartgroupsRelatedByPerformanceExecutionStatisticId());
            }

            $query = ChildStartgroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceExecutionStatistic($this)
                ->count($con);
        }

        return count($this->collStartgroupsRelatedByPerformanceExecutionStatisticId);
    }

    /**
     * Method called to associate a ChildStartgroup object to this object
     * through the ChildStartgroup foreign key attribute.
     *
     * @param  ChildStartgroup $l ChildStartgroup
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addStartgroupRelatedByPerformanceExecutionStatisticId(ChildStartgroup $l)
    {
        if ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId === null) {
            $this->initStartgroupsRelatedByPerformanceExecutionStatisticId();
            $this->collStartgroupsRelatedByPerformanceExecutionStatisticIdPartial = true;
        }

        if (!$this->collStartgroupsRelatedByPerformanceExecutionStatisticId->contains($l)) {
            $this->doAddStartgroupRelatedByPerformanceExecutionStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildStartgroup $startgroupRelatedByPerformanceExecutionStatisticId The ChildStartgroup object to add.
     */
    protected function doAddStartgroupRelatedByPerformanceExecutionStatisticId(ChildStartgroup $startgroupRelatedByPerformanceExecutionStatisticId)
    {
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId[]= $startgroupRelatedByPerformanceExecutionStatisticId;
        $startgroupRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic($this);
    }

    /**
     * @param  ChildStartgroup $startgroupRelatedByPerformanceExecutionStatisticId The ChildStartgroup object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeStartgroupRelatedByPerformanceExecutionStatisticId(ChildStartgroup $startgroupRelatedByPerformanceExecutionStatisticId)
    {
        if ($this->getStartgroupsRelatedByPerformanceExecutionStatisticId()->contains($startgroupRelatedByPerformanceExecutionStatisticId)) {
            $pos = $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->search($startgroupRelatedByPerformanceExecutionStatisticId);
            $this->collStartgroupsRelatedByPerformanceExecutionStatisticId->remove($pos);
            if (null === $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion) {
                $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = clone $this->collStartgroupsRelatedByPerformanceExecutionStatisticId;
                $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->clear();
            }
            $this->startgroupsRelatedByPerformanceExecutionStatisticIdScheduledForDeletion[]= $startgroupRelatedByPerformanceExecutionStatisticId;
            $startgroupRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceExecutionStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceExecutionStatisticIdJoinCompetition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Competition', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceExecutionStatisticId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceExecutionStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceExecutionStatisticIdJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceExecutionStatisticId($query, $con);
    }

    /**
     * Clears out the collStartgroupsRelatedByPerformanceChoreographyStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStartgroupsRelatedByPerformanceChoreographyStatisticId()
     */
    public function clearStartgroupsRelatedByPerformanceChoreographyStatisticId()
    {
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStartgroupsRelatedByPerformanceChoreographyStatisticId collection loaded partially.
     */
    public function resetPartialStartgroupsRelatedByPerformanceChoreographyStatisticId($v = true)
    {
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial = $v;
    }

    /**
     * Initializes the collStartgroupsRelatedByPerformanceChoreographyStatisticId collection.
     *
     * By default this just sets the collStartgroupsRelatedByPerformanceChoreographyStatisticId collection to an empty array (like clearcollStartgroupsRelatedByPerformanceChoreographyStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStartgroupsRelatedByPerformanceChoreographyStatisticId($overrideExisting = true)
    {
        if (null !== $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId && !$overrideExisting) {
            return;
        }
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = new ObjectCollection();
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->setModel('\iuf\junia\model\Startgroup');
    }

    /**
     * Gets an array of ChildStartgroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     * @throws PropelException
     */
    public function getStartgroupsRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId) {
                // return empty collection
                $this->initStartgroupsRelatedByPerformanceChoreographyStatisticId();
            } else {
                $collStartgroupsRelatedByPerformanceChoreographyStatisticId = ChildStartgroupQuery::create(null, $criteria)
                    ->filterByPerformanceChoreographyStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial && count($collStartgroupsRelatedByPerformanceChoreographyStatisticId)) {
                        $this->initStartgroupsRelatedByPerformanceChoreographyStatisticId(false);

                        foreach ($collStartgroupsRelatedByPerformanceChoreographyStatisticId as $obj) {
                            if (false == $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->contains($obj)) {
                                $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->append($obj);
                            }
                        }

                        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial = true;
                    }

                    return $collStartgroupsRelatedByPerformanceChoreographyStatisticId;
                }

                if ($partial && $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId) {
                    foreach ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collStartgroupsRelatedByPerformanceChoreographyStatisticId[] = $obj;
                        }
                    }
                }

                $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = $collStartgroupsRelatedByPerformanceChoreographyStatisticId;
                $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial = false;
            }
        }

        return $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId;
    }

    /**
     * Sets a collection of ChildStartgroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $startgroupsRelatedByPerformanceChoreographyStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setStartgroupsRelatedByPerformanceChoreographyStatisticId(Collection $startgroupsRelatedByPerformanceChoreographyStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildStartgroup[] $startgroupsRelatedByPerformanceChoreographyStatisticIdToDelete */
        $startgroupsRelatedByPerformanceChoreographyStatisticIdToDelete = $this->getStartgroupsRelatedByPerformanceChoreographyStatisticId(new Criteria(), $con)->diff($startgroupsRelatedByPerformanceChoreographyStatisticId);


        $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = $startgroupsRelatedByPerformanceChoreographyStatisticIdToDelete;

        foreach ($startgroupsRelatedByPerformanceChoreographyStatisticIdToDelete as $startgroupRelatedByPerformanceChoreographyStatisticIdRemoved) {
            $startgroupRelatedByPerformanceChoreographyStatisticIdRemoved->setPerformanceChoreographyStatistic(null);
        }

        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = null;
        foreach ($startgroupsRelatedByPerformanceChoreographyStatisticId as $startgroupRelatedByPerformanceChoreographyStatisticId) {
            $this->addStartgroupRelatedByPerformanceChoreographyStatisticId($startgroupRelatedByPerformanceChoreographyStatisticId);
        }

        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = $startgroupsRelatedByPerformanceChoreographyStatisticId;
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Startgroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Startgroup objects.
     * @throws PropelException
     */
    public function countStartgroupsRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStartgroupsRelatedByPerformanceChoreographyStatisticId());
            }

            $query = ChildStartgroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceChoreographyStatistic($this)
                ->count($con);
        }

        return count($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId);
    }

    /**
     * Method called to associate a ChildStartgroup object to this object
     * through the ChildStartgroup foreign key attribute.
     *
     * @param  ChildStartgroup $l ChildStartgroup
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addStartgroupRelatedByPerformanceChoreographyStatisticId(ChildStartgroup $l)
    {
        if ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId === null) {
            $this->initStartgroupsRelatedByPerformanceChoreographyStatisticId();
            $this->collStartgroupsRelatedByPerformanceChoreographyStatisticIdPartial = true;
        }

        if (!$this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->contains($l)) {
            $this->doAddStartgroupRelatedByPerformanceChoreographyStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildStartgroup $startgroupRelatedByPerformanceChoreographyStatisticId The ChildStartgroup object to add.
     */
    protected function doAddStartgroupRelatedByPerformanceChoreographyStatisticId(ChildStartgroup $startgroupRelatedByPerformanceChoreographyStatisticId)
    {
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId[]= $startgroupRelatedByPerformanceChoreographyStatisticId;
        $startgroupRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic($this);
    }

    /**
     * @param  ChildStartgroup $startgroupRelatedByPerformanceChoreographyStatisticId The ChildStartgroup object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeStartgroupRelatedByPerformanceChoreographyStatisticId(ChildStartgroup $startgroupRelatedByPerformanceChoreographyStatisticId)
    {
        if ($this->getStartgroupsRelatedByPerformanceChoreographyStatisticId()->contains($startgroupRelatedByPerformanceChoreographyStatisticId)) {
            $pos = $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->search($startgroupRelatedByPerformanceChoreographyStatisticId);
            $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId->remove($pos);
            if (null === $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion) {
                $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = clone $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId;
                $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->clear();
            }
            $this->startgroupsRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion[]= $startgroupRelatedByPerformanceChoreographyStatisticId;
            $startgroupRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceChoreographyStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceChoreographyStatisticIdJoinCompetition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Competition', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceChoreographyStatisticId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceChoreographyStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceChoreographyStatisticIdJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceChoreographyStatisticId($query, $con);
    }

    /**
     * Clears out the collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStartgroupsRelatedByPerformanceMusicAndTimingStatisticId()
     */
    public function clearStartgroupsRelatedByPerformanceMusicAndTimingStatisticId()
    {
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId collection loaded partially.
     */
    public function resetPartialStartgroupsRelatedByPerformanceMusicAndTimingStatisticId($v = true)
    {
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial = $v;
    }

    /**
     * Initializes the collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId collection.
     *
     * By default this just sets the collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId collection to an empty array (like clearcollStartgroupsRelatedByPerformanceMusicAndTimingStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStartgroupsRelatedByPerformanceMusicAndTimingStatisticId($overrideExisting = true)
    {
        if (null !== $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId && !$overrideExisting) {
            return;
        }
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = new ObjectCollection();
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->setModel('\iuf\junia\model\Startgroup');
    }

    /**
     * Gets an array of ChildStartgroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     * @throws PropelException
     */
    public function getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId) {
                // return empty collection
                $this->initStartgroupsRelatedByPerformanceMusicAndTimingStatisticId();
            } else {
                $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = ChildStartgroupQuery::create(null, $criteria)
                    ->filterByPerformanceMusicAndTimingStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial && count($collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId)) {
                        $this->initStartgroupsRelatedByPerformanceMusicAndTimingStatisticId(false);

                        foreach ($collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                            if (false == $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->contains($obj)) {
                                $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->append($obj);
                            }
                        }

                        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
                    }

                    return $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId;
                }

                if ($partial && $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId) {
                    foreach ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId[] = $obj;
                        }
                    }
                }

                $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = $collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId;
                $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;
            }
        }

        return $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId;
    }

    /**
     * Sets a collection of ChildStartgroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $startgroupsRelatedByPerformanceMusicAndTimingStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setStartgroupsRelatedByPerformanceMusicAndTimingStatisticId(Collection $startgroupsRelatedByPerformanceMusicAndTimingStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildStartgroup[] $startgroupsRelatedByPerformanceMusicAndTimingStatisticIdToDelete */
        $startgroupsRelatedByPerformanceMusicAndTimingStatisticIdToDelete = $this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId(new Criteria(), $con)->diff($startgroupsRelatedByPerformanceMusicAndTimingStatisticId);


        $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = $startgroupsRelatedByPerformanceMusicAndTimingStatisticIdToDelete;

        foreach ($startgroupsRelatedByPerformanceMusicAndTimingStatisticIdToDelete as $startgroupRelatedByPerformanceMusicAndTimingStatisticIdRemoved) {
            $startgroupRelatedByPerformanceMusicAndTimingStatisticIdRemoved->setPerformanceMusicAndTimingStatistic(null);
        }

        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = null;
        foreach ($startgroupsRelatedByPerformanceMusicAndTimingStatisticId as $startgroupRelatedByPerformanceMusicAndTimingStatisticId) {
            $this->addStartgroupRelatedByPerformanceMusicAndTimingStatisticId($startgroupRelatedByPerformanceMusicAndTimingStatisticId);
        }

        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = $startgroupsRelatedByPerformanceMusicAndTimingStatisticId;
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Startgroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Startgroup objects.
     * @throws PropelException
     */
    public function countStartgroupsRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId());
            }

            $query = ChildStartgroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceMusicAndTimingStatistic($this)
                ->count($con);
        }

        return count($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId);
    }

    /**
     * Method called to associate a ChildStartgroup object to this object
     * through the ChildStartgroup foreign key attribute.
     *
     * @param  ChildStartgroup $l ChildStartgroup
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addStartgroupRelatedByPerformanceMusicAndTimingStatisticId(ChildStartgroup $l)
    {
        if ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId === null) {
            $this->initStartgroupsRelatedByPerformanceMusicAndTimingStatisticId();
            $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
        }

        if (!$this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->contains($l)) {
            $this->doAddStartgroupRelatedByPerformanceMusicAndTimingStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildStartgroup $startgroupRelatedByPerformanceMusicAndTimingStatisticId The ChildStartgroup object to add.
     */
    protected function doAddStartgroupRelatedByPerformanceMusicAndTimingStatisticId(ChildStartgroup $startgroupRelatedByPerformanceMusicAndTimingStatisticId)
    {
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId[]= $startgroupRelatedByPerformanceMusicAndTimingStatisticId;
        $startgroupRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic($this);
    }

    /**
     * @param  ChildStartgroup $startgroupRelatedByPerformanceMusicAndTimingStatisticId The ChildStartgroup object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeStartgroupRelatedByPerformanceMusicAndTimingStatisticId(ChildStartgroup $startgroupRelatedByPerformanceMusicAndTimingStatisticId)
    {
        if ($this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId()->contains($startgroupRelatedByPerformanceMusicAndTimingStatisticId)) {
            $pos = $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->search($startgroupRelatedByPerformanceMusicAndTimingStatisticId);
            $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId->remove($pos);
            if (null === $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion) {
                $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = clone $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId;
                $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->clear();
            }
            $this->startgroupsRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion[]= $startgroupRelatedByPerformanceMusicAndTimingStatisticId;
            $startgroupRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceMusicAndTimingStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdJoinCompetition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Competition', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related StartgroupsRelatedByPerformanceMusicAndTimingStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsRelatedByPerformanceMusicAndTimingStatisticIdJoinEvent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getStartgroupsRelatedByPerformanceMusicAndTimingStatisticId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceTotalStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceTotalStatisticId()
     */
    public function clearRoutinesRelatedByPerformanceTotalStatisticId()
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceTotalStatisticId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceTotalStatisticId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceTotalStatisticId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceTotalStatisticId collection to an empty array (like clearcollRoutinesRelatedByPerformanceTotalStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceTotalStatisticId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceTotalStatisticId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceTotalStatisticId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceTotalStatisticId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceTotalStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceTotalStatisticId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceTotalStatisticId();
            } else {
                $collRoutinesRelatedByPerformanceTotalStatisticId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceTotalStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial && count($collRoutinesRelatedByPerformanceTotalStatisticId)) {
                        $this->initRoutinesRelatedByPerformanceTotalStatisticId(false);

                        foreach ($collRoutinesRelatedByPerformanceTotalStatisticId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceTotalStatisticId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceTotalStatisticId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceTotalStatisticId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceTotalStatisticId) {
                    foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceTotalStatisticId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceTotalStatisticId = $collRoutinesRelatedByPerformanceTotalStatisticId;
                $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceTotalStatisticId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceTotalStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceTotalStatisticId(Collection $routinesRelatedByPerformanceTotalStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceTotalStatisticIdToDelete */
        $routinesRelatedByPerformanceTotalStatisticIdToDelete = $this->getRoutinesRelatedByPerformanceTotalStatisticId(new Criteria(), $con)->diff($routinesRelatedByPerformanceTotalStatisticId);


        $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion = $routinesRelatedByPerformanceTotalStatisticIdToDelete;

        foreach ($routinesRelatedByPerformanceTotalStatisticIdToDelete as $routineRelatedByPerformanceTotalStatisticIdRemoved) {
            $routineRelatedByPerformanceTotalStatisticIdRemoved->setPerformanceTotalStatistic(null);
        }

        $this->collRoutinesRelatedByPerformanceTotalStatisticId = null;
        foreach ($routinesRelatedByPerformanceTotalStatisticId as $routineRelatedByPerformanceTotalStatisticId) {
            $this->addRoutineRelatedByPerformanceTotalStatisticId($routineRelatedByPerformanceTotalStatisticId);
        }

        $this->collRoutinesRelatedByPerformanceTotalStatisticId = $routinesRelatedByPerformanceTotalStatisticId;
        $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Routine objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Routine objects.
     * @throws PropelException
     */
    public function countRoutinesRelatedByPerformanceTotalStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceTotalStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceTotalStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceTotalStatisticId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceTotalStatistic($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceTotalStatisticId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceTotalStatisticId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceTotalStatisticId === null) {
            $this->initRoutinesRelatedByPerformanceTotalStatisticId();
            $this->collRoutinesRelatedByPerformanceTotalStatisticIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceTotalStatisticId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceTotalStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceTotalStatisticId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceTotalStatisticId(ChildRoutine $routineRelatedByPerformanceTotalStatisticId)
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticId[]= $routineRelatedByPerformanceTotalStatisticId;
        $routineRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceTotalStatisticId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceTotalStatisticId(ChildRoutine $routineRelatedByPerformanceTotalStatisticId)
    {
        if ($this->getRoutinesRelatedByPerformanceTotalStatisticId()->contains($routineRelatedByPerformanceTotalStatisticId)) {
            $pos = $this->collRoutinesRelatedByPerformanceTotalStatisticId->search($routineRelatedByPerformanceTotalStatisticId);
            $this->collRoutinesRelatedByPerformanceTotalStatisticId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceTotalStatisticId;
                $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceTotalStatisticIdScheduledForDeletion[]= $routineRelatedByPerformanceTotalStatisticId;
            $routineRelatedByPerformanceTotalStatisticId->setPerformanceTotalStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceTotalStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceTotalStatisticIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceTotalStatisticId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceExecutionStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceExecutionStatisticId()
     */
    public function clearRoutinesRelatedByPerformanceExecutionStatisticId()
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceExecutionStatisticId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceExecutionStatisticId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceExecutionStatisticId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceExecutionStatisticId collection to an empty array (like clearcollRoutinesRelatedByPerformanceExecutionStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceExecutionStatisticId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceExecutionStatisticId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceExecutionStatisticId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceExecutionStatisticId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceExecutionStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceExecutionStatisticId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceExecutionStatisticId();
            } else {
                $collRoutinesRelatedByPerformanceExecutionStatisticId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceExecutionStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial && count($collRoutinesRelatedByPerformanceExecutionStatisticId)) {
                        $this->initRoutinesRelatedByPerformanceExecutionStatisticId(false);

                        foreach ($collRoutinesRelatedByPerformanceExecutionStatisticId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceExecutionStatisticId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceExecutionStatisticId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceExecutionStatisticId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceExecutionStatisticId) {
                    foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceExecutionStatisticId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceExecutionStatisticId = $collRoutinesRelatedByPerformanceExecutionStatisticId;
                $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceExecutionStatisticId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceExecutionStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceExecutionStatisticId(Collection $routinesRelatedByPerformanceExecutionStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceExecutionStatisticIdToDelete */
        $routinesRelatedByPerformanceExecutionStatisticIdToDelete = $this->getRoutinesRelatedByPerformanceExecutionStatisticId(new Criteria(), $con)->diff($routinesRelatedByPerformanceExecutionStatisticId);


        $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = $routinesRelatedByPerformanceExecutionStatisticIdToDelete;

        foreach ($routinesRelatedByPerformanceExecutionStatisticIdToDelete as $routineRelatedByPerformanceExecutionStatisticIdRemoved) {
            $routineRelatedByPerformanceExecutionStatisticIdRemoved->setPerformanceExecutionStatistic(null);
        }

        $this->collRoutinesRelatedByPerformanceExecutionStatisticId = null;
        foreach ($routinesRelatedByPerformanceExecutionStatisticId as $routineRelatedByPerformanceExecutionStatisticId) {
            $this->addRoutineRelatedByPerformanceExecutionStatisticId($routineRelatedByPerformanceExecutionStatisticId);
        }

        $this->collRoutinesRelatedByPerformanceExecutionStatisticId = $routinesRelatedByPerformanceExecutionStatisticId;
        $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Routine objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Routine objects.
     * @throws PropelException
     */
    public function countRoutinesRelatedByPerformanceExecutionStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceExecutionStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceExecutionStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceExecutionStatisticId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceExecutionStatistic($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceExecutionStatisticId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceExecutionStatisticId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceExecutionStatisticId === null) {
            $this->initRoutinesRelatedByPerformanceExecutionStatisticId();
            $this->collRoutinesRelatedByPerformanceExecutionStatisticIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceExecutionStatisticId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceExecutionStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceExecutionStatisticId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceExecutionStatisticId(ChildRoutine $routineRelatedByPerformanceExecutionStatisticId)
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticId[]= $routineRelatedByPerformanceExecutionStatisticId;
        $routineRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceExecutionStatisticId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceExecutionStatisticId(ChildRoutine $routineRelatedByPerformanceExecutionStatisticId)
    {
        if ($this->getRoutinesRelatedByPerformanceExecutionStatisticId()->contains($routineRelatedByPerformanceExecutionStatisticId)) {
            $pos = $this->collRoutinesRelatedByPerformanceExecutionStatisticId->search($routineRelatedByPerformanceExecutionStatisticId);
            $this->collRoutinesRelatedByPerformanceExecutionStatisticId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceExecutionStatisticId;
                $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceExecutionStatisticIdScheduledForDeletion[]= $routineRelatedByPerformanceExecutionStatisticId;
            $routineRelatedByPerformanceExecutionStatisticId->setPerformanceExecutionStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceExecutionStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceExecutionStatisticIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceExecutionStatisticId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceChoreographyStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceChoreographyStatisticId()
     */
    public function clearRoutinesRelatedByPerformanceChoreographyStatisticId()
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceChoreographyStatisticId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceChoreographyStatisticId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceChoreographyStatisticId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceChoreographyStatisticId collection to an empty array (like clearcollRoutinesRelatedByPerformanceChoreographyStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceChoreographyStatisticId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceChoreographyStatisticId();
            } else {
                $collRoutinesRelatedByPerformanceChoreographyStatisticId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceChoreographyStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial && count($collRoutinesRelatedByPerformanceChoreographyStatisticId)) {
                        $this->initRoutinesRelatedByPerformanceChoreographyStatisticId(false);

                        foreach ($collRoutinesRelatedByPerformanceChoreographyStatisticId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceChoreographyStatisticId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceChoreographyStatisticId) {
                    foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceChoreographyStatisticId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = $collRoutinesRelatedByPerformanceChoreographyStatisticId;
                $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceChoreographyStatisticId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceChoreographyStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceChoreographyStatisticId(Collection $routinesRelatedByPerformanceChoreographyStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceChoreographyStatisticIdToDelete */
        $routinesRelatedByPerformanceChoreographyStatisticIdToDelete = $this->getRoutinesRelatedByPerformanceChoreographyStatisticId(new Criteria(), $con)->diff($routinesRelatedByPerformanceChoreographyStatisticId);


        $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = $routinesRelatedByPerformanceChoreographyStatisticIdToDelete;

        foreach ($routinesRelatedByPerformanceChoreographyStatisticIdToDelete as $routineRelatedByPerformanceChoreographyStatisticIdRemoved) {
            $routineRelatedByPerformanceChoreographyStatisticIdRemoved->setPerformanceChoreographyStatistic(null);
        }

        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = null;
        foreach ($routinesRelatedByPerformanceChoreographyStatisticId as $routineRelatedByPerformanceChoreographyStatisticId) {
            $this->addRoutineRelatedByPerformanceChoreographyStatisticId($routineRelatedByPerformanceChoreographyStatisticId);
        }

        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = $routinesRelatedByPerformanceChoreographyStatisticId;
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Routine objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Routine objects.
     * @throws PropelException
     */
    public function countRoutinesRelatedByPerformanceChoreographyStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceChoreographyStatisticId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceChoreographyStatistic($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceChoreographyStatisticId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceChoreographyStatisticId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId === null) {
            $this->initRoutinesRelatedByPerformanceChoreographyStatisticId();
            $this->collRoutinesRelatedByPerformanceChoreographyStatisticIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceChoreographyStatisticId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceChoreographyStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceChoreographyStatisticId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceChoreographyStatisticId(ChildRoutine $routineRelatedByPerformanceChoreographyStatisticId)
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId[]= $routineRelatedByPerformanceChoreographyStatisticId;
        $routineRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceChoreographyStatisticId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceChoreographyStatisticId(ChildRoutine $routineRelatedByPerformanceChoreographyStatisticId)
    {
        if ($this->getRoutinesRelatedByPerformanceChoreographyStatisticId()->contains($routineRelatedByPerformanceChoreographyStatisticId)) {
            $pos = $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->search($routineRelatedByPerformanceChoreographyStatisticId);
            $this->collRoutinesRelatedByPerformanceChoreographyStatisticId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceChoreographyStatisticId;
                $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceChoreographyStatisticIdScheduledForDeletion[]= $routineRelatedByPerformanceChoreographyStatisticId;
            $routineRelatedByPerformanceChoreographyStatisticId->setPerformanceChoreographyStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceChoreographyStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceChoreographyStatisticIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceChoreographyStatisticId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceMusicAndTimingStatisticId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceMusicAndTimingStatisticId()
     */
    public function clearRoutinesRelatedByPerformanceMusicAndTimingStatisticId()
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceMusicAndTimingStatisticId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceMusicAndTimingStatisticId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceMusicAndTimingStatisticId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceMusicAndTimingStatisticId collection to an empty array (like clearcollRoutinesRelatedByPerformanceMusicAndTimingStatisticId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceMusicAndTimingStatisticId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistic is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticId();
            } else {
                $collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceMusicAndTimingStatistic($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial && count($collRoutinesRelatedByPerformanceMusicAndTimingStatisticId)) {
                        $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticId(false);

                        foreach ($collRoutinesRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceMusicAndTimingStatisticId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId) {
                    foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceMusicAndTimingStatisticId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = $collRoutinesRelatedByPerformanceMusicAndTimingStatisticId;
                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceMusicAndTimingStatisticId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceMusicAndTimingStatisticId(Collection $routinesRelatedByPerformanceMusicAndTimingStatisticId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceMusicAndTimingStatisticIdToDelete */
        $routinesRelatedByPerformanceMusicAndTimingStatisticIdToDelete = $this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticId(new Criteria(), $con)->diff($routinesRelatedByPerformanceMusicAndTimingStatisticId);


        $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = $routinesRelatedByPerformanceMusicAndTimingStatisticIdToDelete;

        foreach ($routinesRelatedByPerformanceMusicAndTimingStatisticIdToDelete as $routineRelatedByPerformanceMusicAndTimingStatisticIdRemoved) {
            $routineRelatedByPerformanceMusicAndTimingStatisticIdRemoved->setPerformanceMusicAndTimingStatistic(null);
        }

        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = null;
        foreach ($routinesRelatedByPerformanceMusicAndTimingStatisticId as $routineRelatedByPerformanceMusicAndTimingStatisticId) {
            $this->addRoutineRelatedByPerformanceMusicAndTimingStatisticId($routineRelatedByPerformanceMusicAndTimingStatisticId);
        }

        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = $routinesRelatedByPerformanceMusicAndTimingStatisticId;
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Routine objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Routine objects.
     * @throws PropelException
     */
    public function countRoutinesRelatedByPerformanceMusicAndTimingStatisticId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceMusicAndTimingStatistic($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistic The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceMusicAndTimingStatisticId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId === null) {
            $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticId();
            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceMusicAndTimingStatisticId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceMusicAndTimingStatisticId(ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticId)
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId[]= $routineRelatedByPerformanceMusicAndTimingStatisticId;
        $routineRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistic The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceMusicAndTimingStatisticId(ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticId)
    {
        if ($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticId()->contains($routineRelatedByPerformanceMusicAndTimingStatisticId)) {
            $pos = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->search($routineRelatedByPerformanceMusicAndTimingStatisticId);
            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId;
                $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceMusicAndTimingStatisticIdScheduledForDeletion[]= $routineRelatedByPerformanceMusicAndTimingStatisticId;
            $routineRelatedByPerformanceMusicAndTimingStatisticId->setPerformanceMusicAndTimingStatistic(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistic is new, it will return
     * an empty collection; or if this PerformanceStatistic has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceMusicAndTimingStatisticId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistic.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceMusicAndTimingStatisticIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticId($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->min = null;
        $this->max = null;
        $this->range = null;
        $this->median = null;
        $this->average = null;
        $this->variance = null;
        $this->standard_deviation = null;
        $this->variability_coefficient = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collEventsRelatedByPerformanceTotalStatisticId) {
                foreach ($this->collEventsRelatedByPerformanceTotalStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventsRelatedByPerformanceExecutionStatisticId) {
                foreach ($this->collEventsRelatedByPerformanceExecutionStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventsRelatedByPerformanceChoreographyStatisticId) {
                foreach ($this->collEventsRelatedByPerformanceChoreographyStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId) {
                foreach ($this->collEventsRelatedByPerformanceMusicAndTimingStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStartgroupsRelatedByPerformanceTotalStatisticId) {
                foreach ($this->collStartgroupsRelatedByPerformanceTotalStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId) {
                foreach ($this->collStartgroupsRelatedByPerformanceExecutionStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId) {
                foreach ($this->collStartgroupsRelatedByPerformanceChoreographyStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId) {
                foreach ($this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceTotalStatisticId) {
                foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceExecutionStatisticId) {
                foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId) {
                foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId) {
                foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collEventsRelatedByPerformanceTotalStatisticId = null;
        $this->collEventsRelatedByPerformanceExecutionStatisticId = null;
        $this->collEventsRelatedByPerformanceChoreographyStatisticId = null;
        $this->collEventsRelatedByPerformanceMusicAndTimingStatisticId = null;
        $this->collStartgroupsRelatedByPerformanceTotalStatisticId = null;
        $this->collStartgroupsRelatedByPerformanceExecutionStatisticId = null;
        $this->collStartgroupsRelatedByPerformanceChoreographyStatisticId = null;
        $this->collStartgroupsRelatedByPerformanceMusicAndTimingStatisticId = null;
        $this->collRoutinesRelatedByPerformanceTotalStatisticId = null;
        $this->collRoutinesRelatedByPerformanceExecutionStatisticId = null;
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticId = null;
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PerformanceStatisticTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}

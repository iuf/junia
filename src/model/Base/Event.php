<?php

namespace iuf\junia\model\Base;

use \DateTime;
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
use Propel\Runtime\Util\PropelDateTime;
use iuf\junia\model\Event as ChildEvent;
use iuf\junia\model\EventQuery as ChildEventQuery;
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Startgroup as ChildStartgroup;
use iuf\junia\model\StartgroupQuery as ChildStartgroupQuery;
use iuf\junia\model\Map\EventTableMap;

/**
 * Base class that represents a row from the 'kk_junia_event' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Event implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\iuf\\junia\\model\\Map\\EventTableMap';


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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the start field.
     * @var        \DateTime
     */
    protected $start;

    /**
     * The value for the end field.
     * @var        \DateTime
     */
    protected $end;

    /**
     * The value for the performance_total_statistic_id field.
     * @var        int
     */
    protected $performance_total_statistic_id;

    /**
     * The value for the performance_execution_statistic_id field.
     * @var        int
     */
    protected $performance_execution_statistic_id;

    /**
     * The value for the performance_choreography_statistic_id field.
     * @var        int
     */
    protected $performance_choreography_statistic_id;

    /**
     * The value for the performance_music_and_timing_statistic_id field.
     * @var        int
     */
    protected $performance_music_and_timing_statistic_id;

    /**
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

    /**
     * @var        ChildPerformanceStatistic
     */
    protected $aPerformanceTotalStatistic;

    /**
     * @var        ChildPerformanceStatistic
     */
    protected $aPerformanceExecutionStatistic;

    /**
     * @var        ChildPerformanceStatistic
     */
    protected $aPerformanceChoreographyStatistic;

    /**
     * @var        ChildPerformanceStatistic
     */
    protected $aPerformanceMusicAndTimingStatistic;

    /**
     * @var        ObjectCollection|ChildStartgroup[] Collection to store aggregation of ChildStartgroup objects.
     */
    protected $collStartgroups;
    protected $collStartgroupsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStartgroup[]
     */
    protected $startgroupsScheduledForDeletion = null;

    /**
     * Initializes internal state of iuf\junia\model\Base\Event object.
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
     * Compares this with another <code>Event</code> instance.  If
     * <code>obj</code> is an instance of <code>Event</code>, delegates to
     * <code>equals(Event)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Event The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [start] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStart($format = NULL)
    {
        if ($format === null) {
            return $this->start;
        } else {
            return $this->start instanceof \DateTime ? $this->start->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEnd($format = NULL)
    {
        if ($format === null) {
            return $this->end;
        } else {
            return $this->end instanceof \DateTime ? $this->end->format($format) : null;
        }
    }

    /**
     * Get the [performance_total_statistic_id] column value.
     *
     * @return int
     */
    public function getPerformanceTotalStatisticId()
    {
        return $this->performance_total_statistic_id;
    }

    /**
     * Get the [performance_execution_statistic_id] column value.
     *
     * @return int
     */
    public function getPerformanceExecutionStatisticId()
    {
        return $this->performance_execution_statistic_id;
    }

    /**
     * Get the [performance_choreography_statistic_id] column value.
     *
     * @return int
     */
    public function getPerformanceChoreographyStatisticId()
    {
        return $this->performance_choreography_statistic_id;
    }

    /**
     * Get the [performance_music_and_timing_statistic_id] column value.
     *
     * @return int
     */
    public function getPerformanceMusicAndTimingStatisticId()
    {
        return $this->performance_music_and_timing_statistic_id;
    }

    /**
     * Get the [slug] column value.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EventTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[EventTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of [start] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start !== null || $dt !== null) {
            if ($this->start === null || $dt === null || $dt->format("Y-m-d") !== $this->start->format("Y-m-d")) {
                $this->start = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_START] = true;
            }
        } // if either are not null

        return $this;
    } // setStart()

    /**
     * Sets the value of [end] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end !== null || $dt !== null) {
            if ($this->end === null || $dt === null || $dt->format("Y-m-d") !== $this->end->format("Y-m-d")) {
                $this->end = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_END] = true;
            }
        } // if either are not null

        return $this;
    } // setEnd()

    /**
     * Set the value of [performance_total_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setPerformanceTotalStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_total_statistic_id !== $v) {
            $this->performance_total_statistic_id = $v;
            $this->modifiedColumns[EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID] = true;
        }

        if ($this->aPerformanceTotalStatistic !== null && $this->aPerformanceTotalStatistic->getId() !== $v) {
            $this->aPerformanceTotalStatistic = null;
        }

        return $this;
    } // setPerformanceTotalStatisticId()

    /**
     * Set the value of [performance_execution_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setPerformanceExecutionStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_execution_statistic_id !== $v) {
            $this->performance_execution_statistic_id = $v;
            $this->modifiedColumns[EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID] = true;
        }

        if ($this->aPerformanceExecutionStatistic !== null && $this->aPerformanceExecutionStatistic->getId() !== $v) {
            $this->aPerformanceExecutionStatistic = null;
        }

        return $this;
    } // setPerformanceExecutionStatisticId()

    /**
     * Set the value of [performance_choreography_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setPerformanceChoreographyStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_choreography_statistic_id !== $v) {
            $this->performance_choreography_statistic_id = $v;
            $this->modifiedColumns[EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID] = true;
        }

        if ($this->aPerformanceChoreographyStatistic !== null && $this->aPerformanceChoreographyStatistic->getId() !== $v) {
            $this->aPerformanceChoreographyStatistic = null;
        }

        return $this;
    } // setPerformanceChoreographyStatisticId()

    /**
     * Set the value of [performance_music_and_timing_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setPerformanceMusicAndTimingStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_music_and_timing_statistic_id !== $v) {
            $this->performance_music_and_timing_statistic_id = $v;
            $this->modifiedColumns[EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID] = true;
        }

        if ($this->aPerformanceMusicAndTimingStatistic !== null && $this->aPerformanceMusicAndTimingStatistic->getId() !== $v) {
            $this->aPerformanceMusicAndTimingStatistic = null;
        }

        return $this;
    } // setPerformanceMusicAndTimingStatisticId()

    /**
     * Set the value of [slug] column.
     *
     * @param string $v new value
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[EventTableMap::COL_SLUG] = true;
        }

        return $this;
    } // setSlug()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventTableMap::translateFieldName('Start', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->start = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventTableMap::translateFieldName('End', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->end = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventTableMap::translateFieldName('PerformanceTotalStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_total_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EventTableMap::translateFieldName('PerformanceExecutionStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_execution_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EventTableMap::translateFieldName('PerformanceChoreographyStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_choreography_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EventTableMap::translateFieldName('PerformanceMusicAndTimingStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_music_and_timing_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EventTableMap::translateFieldName('Slug', TableMap::TYPE_PHPNAME, $indexType)];
            $this->slug = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = EventTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\iuf\\junia\\model\\Event'), 0, $e);
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
        if ($this->aPerformanceTotalStatistic !== null && $this->performance_total_statistic_id !== $this->aPerformanceTotalStatistic->getId()) {
            $this->aPerformanceTotalStatistic = null;
        }
        if ($this->aPerformanceExecutionStatistic !== null && $this->performance_execution_statistic_id !== $this->aPerformanceExecutionStatistic->getId()) {
            $this->aPerformanceExecutionStatistic = null;
        }
        if ($this->aPerformanceChoreographyStatistic !== null && $this->performance_choreography_statistic_id !== $this->aPerformanceChoreographyStatistic->getId()) {
            $this->aPerformanceChoreographyStatistic = null;
        }
        if ($this->aPerformanceMusicAndTimingStatistic !== null && $this->performance_music_and_timing_statistic_id !== $this->aPerformanceMusicAndTimingStatistic->getId()) {
            $this->aPerformanceMusicAndTimingStatistic = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPerformanceTotalStatistic = null;
            $this->aPerformanceExecutionStatistic = null;
            $this->aPerformanceChoreographyStatistic = null;
            $this->aPerformanceMusicAndTimingStatistic = null;
            $this->collStartgroups = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Event::setDeleted()
     * @see Event::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            // sluggable behavior

            if ($this->isColumnModified(EventTableMap::COL_SLUG) && $this->getSlug()) {
                $this->setSlug($this->makeSlugUnique($this->getSlug()));
            } else {
                $this->setSlug($this->createSlug());
            }
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
                EventTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPerformanceTotalStatistic !== null) {
                if ($this->aPerformanceTotalStatistic->isModified() || $this->aPerformanceTotalStatistic->isNew()) {
                    $affectedRows += $this->aPerformanceTotalStatistic->save($con);
                }
                $this->setPerformanceTotalStatistic($this->aPerformanceTotalStatistic);
            }

            if ($this->aPerformanceExecutionStatistic !== null) {
                if ($this->aPerformanceExecutionStatistic->isModified() || $this->aPerformanceExecutionStatistic->isNew()) {
                    $affectedRows += $this->aPerformanceExecutionStatistic->save($con);
                }
                $this->setPerformanceExecutionStatistic($this->aPerformanceExecutionStatistic);
            }

            if ($this->aPerformanceChoreographyStatistic !== null) {
                if ($this->aPerformanceChoreographyStatistic->isModified() || $this->aPerformanceChoreographyStatistic->isNew()) {
                    $affectedRows += $this->aPerformanceChoreographyStatistic->save($con);
                }
                $this->setPerformanceChoreographyStatistic($this->aPerformanceChoreographyStatistic);
            }

            if ($this->aPerformanceMusicAndTimingStatistic !== null) {
                if ($this->aPerformanceMusicAndTimingStatistic->isModified() || $this->aPerformanceMusicAndTimingStatistic->isNew()) {
                    $affectedRows += $this->aPerformanceMusicAndTimingStatistic->save($con);
                }
                $this->setPerformanceMusicAndTimingStatistic($this->aPerformanceMusicAndTimingStatistic);
            }

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

            if ($this->startgroupsScheduledForDeletion !== null) {
                if (!$this->startgroupsScheduledForDeletion->isEmpty()) {
                    \iuf\junia\model\StartgroupQuery::create()
                        ->filterByPrimaryKeys($this->startgroupsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->startgroupsScheduledForDeletion = null;
                }
            }

            if ($this->collStartgroups !== null) {
                foreach ($this->collStartgroups as $referrerFK) {
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

        $this->modifiedColumns[EventTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(EventTableMap::COL_START)) {
            $modifiedColumns[':p' . $index++]  = '`start`';
        }
        if ($this->isColumnModified(EventTableMap::COL_END)) {
            $modifiedColumns[':p' . $index++]  = '`end`';
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_total_statistic_id`';
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_execution_statistic_id`';
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_choreography_statistic_id`';
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_music_and_timing_statistic_id`';
        }
        if ($this->isColumnModified(EventTableMap::COL_SLUG)) {
            $modifiedColumns[':p' . $index++]  = '`slug`';
        }

        $sql = sprintf(
            'INSERT INTO `kk_junia_event` (%s) VALUES (%s)',
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
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`start`':
                        $stmt->bindValue($identifier, $this->start ? $this->start->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`end`':
                        $stmt->bindValue($identifier, $this->end ? $this->end->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`performance_total_statistic_id`':
                        $stmt->bindValue($identifier, $this->performance_total_statistic_id, PDO::PARAM_INT);
                        break;
                    case '`performance_execution_statistic_id`':
                        $stmt->bindValue($identifier, $this->performance_execution_statistic_id, PDO::PARAM_INT);
                        break;
                    case '`performance_choreography_statistic_id`':
                        $stmt->bindValue($identifier, $this->performance_choreography_statistic_id, PDO::PARAM_INT);
                        break;
                    case '`performance_music_and_timing_statistic_id`':
                        $stmt->bindValue($identifier, $this->performance_music_and_timing_statistic_id, PDO::PARAM_INT);
                        break;
                    case '`slug`':
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
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
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getStart();
                break;
            case 3:
                return $this->getEnd();
                break;
            case 4:
                return $this->getPerformanceTotalStatisticId();
                break;
            case 5:
                return $this->getPerformanceExecutionStatisticId();
                break;
            case 6:
                return $this->getPerformanceChoreographyStatisticId();
                break;
            case 7:
                return $this->getPerformanceMusicAndTimingStatisticId();
                break;
            case 8:
                return $this->getSlug();
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

        if (isset($alreadyDumpedObjects['Event'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Event'][$this->hashCode()] = true;
        $keys = EventTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getStart(),
            $keys[3] => $this->getEnd(),
            $keys[4] => $this->getPerformanceTotalStatisticId(),
            $keys[5] => $this->getPerformanceExecutionStatisticId(),
            $keys[6] => $this->getPerformanceChoreographyStatisticId(),
            $keys[7] => $this->getPerformanceMusicAndTimingStatisticId(),
            $keys[8] => $this->getSlug(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[2]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[2]];
            $result[$keys[2]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPerformanceTotalStatistic) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'performanceStatistic';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_performance_statistic';
                        break;
                    default:
                        $key = 'PerformanceStatistic';
                }

                $result[$key] = $this->aPerformanceTotalStatistic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPerformanceExecutionStatistic) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'performanceStatistic';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_performance_statistic';
                        break;
                    default:
                        $key = 'PerformanceStatistic';
                }

                $result[$key] = $this->aPerformanceExecutionStatistic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPerformanceChoreographyStatistic) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'performanceStatistic';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_performance_statistic';
                        break;
                    default:
                        $key = 'PerformanceStatistic';
                }

                $result[$key] = $this->aPerformanceChoreographyStatistic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPerformanceMusicAndTimingStatistic) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'performanceStatistic';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_performance_statistic';
                        break;
                    default:
                        $key = 'PerformanceStatistic';
                }

                $result[$key] = $this->aPerformanceMusicAndTimingStatistic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collStartgroups) {

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

                $result[$key] = $this->collStartgroups->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\iuf\junia\model\Event
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\iuf\junia\model\Event
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setStart($value);
                break;
            case 3:
                $this->setEnd($value);
                break;
            case 4:
                $this->setPerformanceTotalStatisticId($value);
                break;
            case 5:
                $this->setPerformanceExecutionStatisticId($value);
                break;
            case 6:
                $this->setPerformanceChoreographyStatisticId($value);
                break;
            case 7:
                $this->setPerformanceMusicAndTimingStatisticId($value);
                break;
            case 8:
                $this->setSlug($value);
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
        $keys = EventTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setStart($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEnd($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPerformanceTotalStatisticId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPerformanceExecutionStatisticId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPerformanceChoreographyStatisticId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPerformanceMusicAndTimingStatisticId($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSlug($arr[$keys[8]]);
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
     * @return $this|\iuf\junia\model\Event The current object, for fluid interface
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
        $criteria = new Criteria(EventTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTableMap::COL_ID)) {
            $criteria->add(EventTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $criteria->add(EventTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(EventTableMap::COL_START)) {
            $criteria->add(EventTableMap::COL_START, $this->start);
        }
        if ($this->isColumnModified(EventTableMap::COL_END)) {
            $criteria->add(EventTableMap::COL_END, $this->end);
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $criteria->add(EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $this->performance_total_statistic_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $criteria->add(EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $this->performance_execution_statistic_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $criteria->add(EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $this->performance_choreography_statistic_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $criteria->add(EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $this->performance_music_and_timing_statistic_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_SLUG)) {
            $criteria->add(EventTableMap::COL_SLUG, $this->slug);
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
        $criteria = ChildEventQuery::create();
        $criteria->add(EventTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \iuf\junia\model\Event (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setStart($this->getStart());
        $copyObj->setEnd($this->getEnd());
        $copyObj->setPerformanceTotalStatisticId($this->getPerformanceTotalStatisticId());
        $copyObj->setPerformanceExecutionStatisticId($this->getPerformanceExecutionStatisticId());
        $copyObj->setPerformanceChoreographyStatisticId($this->getPerformanceChoreographyStatisticId());
        $copyObj->setPerformanceMusicAndTimingStatisticId($this->getPerformanceMusicAndTimingStatisticId());
        $copyObj->setSlug($this->getSlug());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getStartgroups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStartgroup($relObj->copy($deepCopy));
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
     * @return \iuf\junia\model\Event Clone of current object.
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
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerformanceTotalStatistic(ChildPerformanceStatistic $v = null)
    {
        if ($v === null) {
            $this->setPerformanceTotalStatisticId(NULL);
        } else {
            $this->setPerformanceTotalStatisticId($v->getId());
        }

        $this->aPerformanceTotalStatistic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerformanceStatistic object, it will not be re-added.
        if ($v !== null) {
            $v->addEventRelatedByPerformanceTotalStatisticId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerformanceStatistic object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerformanceStatistic The associated ChildPerformanceStatistic object.
     * @throws PropelException
     */
    public function getPerformanceTotalStatistic(ConnectionInterface $con = null)
    {
        if ($this->aPerformanceTotalStatistic === null && ($this->performance_total_statistic_id !== null)) {
            $this->aPerformanceTotalStatistic = ChildPerformanceStatisticQuery::create()->findPk($this->performance_total_statistic_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerformanceTotalStatistic->addEventsRelatedByPerformanceTotalStatisticId($this);
             */
        }

        return $this->aPerformanceTotalStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerformanceExecutionStatistic(ChildPerformanceStatistic $v = null)
    {
        if ($v === null) {
            $this->setPerformanceExecutionStatisticId(NULL);
        } else {
            $this->setPerformanceExecutionStatisticId($v->getId());
        }

        $this->aPerformanceExecutionStatistic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerformanceStatistic object, it will not be re-added.
        if ($v !== null) {
            $v->addEventRelatedByPerformanceExecutionStatisticId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerformanceStatistic object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerformanceStatistic The associated ChildPerformanceStatistic object.
     * @throws PropelException
     */
    public function getPerformanceExecutionStatistic(ConnectionInterface $con = null)
    {
        if ($this->aPerformanceExecutionStatistic === null && ($this->performance_execution_statistic_id !== null)) {
            $this->aPerformanceExecutionStatistic = ChildPerformanceStatisticQuery::create()->findPk($this->performance_execution_statistic_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerformanceExecutionStatistic->addEventsRelatedByPerformanceExecutionStatisticId($this);
             */
        }

        return $this->aPerformanceExecutionStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerformanceChoreographyStatistic(ChildPerformanceStatistic $v = null)
    {
        if ($v === null) {
            $this->setPerformanceChoreographyStatisticId(NULL);
        } else {
            $this->setPerformanceChoreographyStatisticId($v->getId());
        }

        $this->aPerformanceChoreographyStatistic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerformanceStatistic object, it will not be re-added.
        if ($v !== null) {
            $v->addEventRelatedByPerformanceChoreographyStatisticId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerformanceStatistic object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerformanceStatistic The associated ChildPerformanceStatistic object.
     * @throws PropelException
     */
    public function getPerformanceChoreographyStatistic(ConnectionInterface $con = null)
    {
        if ($this->aPerformanceChoreographyStatistic === null && ($this->performance_choreography_statistic_id !== null)) {
            $this->aPerformanceChoreographyStatistic = ChildPerformanceStatisticQuery::create()->findPk($this->performance_choreography_statistic_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerformanceChoreographyStatistic->addEventsRelatedByPerformanceChoreographyStatisticId($this);
             */
        }

        return $this->aPerformanceChoreographyStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerformanceMusicAndTimingStatistic(ChildPerformanceStatistic $v = null)
    {
        if ($v === null) {
            $this->setPerformanceMusicAndTimingStatisticId(NULL);
        } else {
            $this->setPerformanceMusicAndTimingStatisticId($v->getId());
        }

        $this->aPerformanceMusicAndTimingStatistic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerformanceStatistic object, it will not be re-added.
        if ($v !== null) {
            $v->addEventRelatedByPerformanceMusicAndTimingStatisticId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerformanceStatistic object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerformanceStatistic The associated ChildPerformanceStatistic object.
     * @throws PropelException
     */
    public function getPerformanceMusicAndTimingStatistic(ConnectionInterface $con = null)
    {
        if ($this->aPerformanceMusicAndTimingStatistic === null && ($this->performance_music_and_timing_statistic_id !== null)) {
            $this->aPerformanceMusicAndTimingStatistic = ChildPerformanceStatisticQuery::create()->findPk($this->performance_music_and_timing_statistic_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerformanceMusicAndTimingStatistic->addEventsRelatedByPerformanceMusicAndTimingStatisticId($this);
             */
        }

        return $this->aPerformanceMusicAndTimingStatistic;
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
        if ('Startgroup' == $relationName) {
            return $this->initStartgroups();
        }
    }

    /**
     * Clears out the collStartgroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStartgroups()
     */
    public function clearStartgroups()
    {
        $this->collStartgroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStartgroups collection loaded partially.
     */
    public function resetPartialStartgroups($v = true)
    {
        $this->collStartgroupsPartial = $v;
    }

    /**
     * Initializes the collStartgroups collection.
     *
     * By default this just sets the collStartgroups collection to an empty array (like clearcollStartgroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStartgroups($overrideExisting = true)
    {
        if (null !== $this->collStartgroups && !$overrideExisting) {
            return;
        }
        $this->collStartgroups = new ObjectCollection();
        $this->collStartgroups->setModel('\iuf\junia\model\Startgroup');
    }

    /**
     * Gets an array of ChildStartgroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     * @throws PropelException
     */
    public function getStartgroups(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsPartial && !$this->isNew();
        if (null === $this->collStartgroups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStartgroups) {
                // return empty collection
                $this->initStartgroups();
            } else {
                $collStartgroups = ChildStartgroupQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStartgroupsPartial && count($collStartgroups)) {
                        $this->initStartgroups(false);

                        foreach ($collStartgroups as $obj) {
                            if (false == $this->collStartgroups->contains($obj)) {
                                $this->collStartgroups->append($obj);
                            }
                        }

                        $this->collStartgroupsPartial = true;
                    }

                    return $collStartgroups;
                }

                if ($partial && $this->collStartgroups) {
                    foreach ($this->collStartgroups as $obj) {
                        if ($obj->isNew()) {
                            $collStartgroups[] = $obj;
                        }
                    }
                }

                $this->collStartgroups = $collStartgroups;
                $this->collStartgroupsPartial = false;
            }
        }

        return $this->collStartgroups;
    }

    /**
     * Sets a collection of ChildStartgroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $startgroups A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setStartgroups(Collection $startgroups, ConnectionInterface $con = null)
    {
        /** @var ChildStartgroup[] $startgroupsToDelete */
        $startgroupsToDelete = $this->getStartgroups(new Criteria(), $con)->diff($startgroups);


        $this->startgroupsScheduledForDeletion = $startgroupsToDelete;

        foreach ($startgroupsToDelete as $startgroupRemoved) {
            $startgroupRemoved->setEvent(null);
        }

        $this->collStartgroups = null;
        foreach ($startgroups as $startgroup) {
            $this->addStartgroup($startgroup);
        }

        $this->collStartgroups = $startgroups;
        $this->collStartgroupsPartial = false;

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
    public function countStartgroups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStartgroupsPartial && !$this->isNew();
        if (null === $this->collStartgroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStartgroups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStartgroups());
            }

            $query = ChildStartgroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collStartgroups);
    }

    /**
     * Method called to associate a ChildStartgroup object to this object
     * through the ChildStartgroup foreign key attribute.
     *
     * @param  ChildStartgroup $l ChildStartgroup
     * @return $this|\iuf\junia\model\Event The current object (for fluent API support)
     */
    public function addStartgroup(ChildStartgroup $l)
    {
        if ($this->collStartgroups === null) {
            $this->initStartgroups();
            $this->collStartgroupsPartial = true;
        }

        if (!$this->collStartgroups->contains($l)) {
            $this->doAddStartgroup($l);
        }

        return $this;
    }

    /**
     * @param ChildStartgroup $startgroup The ChildStartgroup object to add.
     */
    protected function doAddStartgroup(ChildStartgroup $startgroup)
    {
        $this->collStartgroups[]= $startgroup;
        $startgroup->setEvent($this);
    }

    /**
     * @param  ChildStartgroup $startgroup The ChildStartgroup object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeStartgroup(ChildStartgroup $startgroup)
    {
        if ($this->getStartgroups()->contains($startgroup)) {
            $pos = $this->collStartgroups->search($startgroup);
            $this->collStartgroups->remove($pos);
            if (null === $this->startgroupsScheduledForDeletion) {
                $this->startgroupsScheduledForDeletion = clone $this->collStartgroups;
                $this->startgroupsScheduledForDeletion->clear();
            }
            $this->startgroupsScheduledForDeletion[]= clone $startgroup;
            $startgroup->setEvent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Startgroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsJoinCompetition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('Competition', $joinBehavior);

        return $this->getStartgroups($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Startgroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsJoinPerformanceTotalStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('PerformanceTotalStatistic', $joinBehavior);

        return $this->getStartgroups($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Startgroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsJoinPerformanceExecutionStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('PerformanceExecutionStatistic', $joinBehavior);

        return $this->getStartgroups($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Startgroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsJoinPerformanceChoreographyStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('PerformanceChoreographyStatistic', $joinBehavior);

        return $this->getStartgroups($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Startgroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStartgroup[] List of ChildStartgroup objects
     */
    public function getStartgroupsJoinPerformanceMusicAndTimingStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStartgroupQuery::create(null, $criteria);
        $query->joinWith('PerformanceMusicAndTimingStatistic', $joinBehavior);

        return $this->getStartgroups($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPerformanceTotalStatistic) {
            $this->aPerformanceTotalStatistic->removeEventRelatedByPerformanceTotalStatisticId($this);
        }
        if (null !== $this->aPerformanceExecutionStatistic) {
            $this->aPerformanceExecutionStatistic->removeEventRelatedByPerformanceExecutionStatisticId($this);
        }
        if (null !== $this->aPerformanceChoreographyStatistic) {
            $this->aPerformanceChoreographyStatistic->removeEventRelatedByPerformanceChoreographyStatisticId($this);
        }
        if (null !== $this->aPerformanceMusicAndTimingStatistic) {
            $this->aPerformanceMusicAndTimingStatistic->removeEventRelatedByPerformanceMusicAndTimingStatisticId($this);
        }
        $this->id = null;
        $this->name = null;
        $this->start = null;
        $this->end = null;
        $this->performance_total_statistic_id = null;
        $this->performance_execution_statistic_id = null;
        $this->performance_choreography_statistic_id = null;
        $this->performance_music_and_timing_statistic_id = null;
        $this->slug = null;
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
            if ($this->collStartgroups) {
                foreach ($this->collStartgroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collStartgroups = null;
        $this->aPerformanceTotalStatistic = null;
        $this->aPerformanceExecutionStatistic = null;
        $this->aPerformanceChoreographyStatistic = null;
        $this->aPerformanceMusicAndTimingStatistic = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'name' column
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

    // sluggable behavior

    /**
     * Create a unique slug based on the object
     *
     * @return string The object slug
     */
    protected function createSlug()
    {
        $slug = $this->createRawSlug();
        $slug = $this->limitSlugSize($slug);
        $slug = $this->makeSlugUnique($slug);

        return $slug;
    }

    /**
     * Create the slug from the appropriate columns
     *
     * @return string
     */
    protected function createRawSlug()
    {
        return $this->cleanupSlugPart($this->__toString());
    }

    /**
     * Cleanup a string to make a slug of it
     * Removes special characters, replaces blanks with a separator, and trim it
     *
     * @param     string $slug        the text to slugify
     * @param     string $replacement the separator used by slug
     * @return    string               the slugified text
     */
    protected static function cleanupSlugPart($slug, $replacement = '-')
    {
        // transliterate
        if (function_exists('iconv')) {
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        }

        // lowercase
        if (function_exists('mb_strtolower')) {
            $slug = mb_strtolower($slug);
        } else {
            $slug = strtolower($slug);
        }

        // remove accents resulting from OSX's iconv
        $slug = str_replace(array('\'', '`', '^'), '', $slug);

        // replace non letter or digits with separator
        $slug = preg_replace('/\W+/', $replacement, $slug);

        // trim
        $slug = trim($slug, $replacement);

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }


    /**
     * Make sure the slug is short enough to accommodate the column size
     *
     * @param    string $slug            the slug to check
     *
     * @return string                        the truncated slug
     */
    protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
    {
        // check length, as suffix could put it over maximum
        if (strlen($slug) > (255 - $incrementReservedSpace)) {
            $slug = substr($slug, 0, 255 - $incrementReservedSpace);
        }

        return $slug;
    }


    /**
     * Get the slug, ensuring its uniqueness
     *
     * @param    string $slug            the slug to check
     * @param    string $separator       the separator used by slug
     * @param    int    $alreadyExists   false for the first try, true for the second, and take the high count + 1
     * @return   string                   the unique slug
     */
    protected function makeSlugUnique($slug, $separator = '-', $alreadyExists = false)
    {
        if (!$alreadyExists) {
            $slug2 = $slug;
        } else {
            $slug2 = $slug . $separator;

            $count = \iuf\junia\model\EventQuery::create()
                ->filterBySlug($this->getSlug())
                ->filterByPrimaryKey($this->getPrimaryKey())
            ->count();

            if (1 == $count) {
                return $this->getSlug();
            }
        }

        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('keeko');
        $col = 'q.Slug';
        $compare = $alreadyExists ? $adapter->compareRegex($col, '?') : sprintf('%s = ?', $col);

        $query = \iuf\junia\model\EventQuery::create('q')
            ->where($compare, $alreadyExists ? '^' . $slug2 . '[0-9]+$' : $slug2)
            ->prune($this)
        ;

        if (!$alreadyExists) {
            $count = $query->count();
            if ($count > 0) {
                return $this->makeSlugUnique($slug, $separator, true);
            }

            return $slug2;
        }

        $adapter = \Propel\Runtime\Propel::getServiceContainer()->getAdapter('keeko');
        // Already exists
        $object = $query
            ->addDescendingOrderByColumn($adapter->strLength('slug'))
            ->addDescendingOrderByColumn('slug')
        ->findOne();

        // First duplicate slug
        if (null == $object) {
            return $slug2 . '1';
        }

        $slugNum = substr($object->getSlug(), strlen($slug) + 1);
        if (0 == $slugNum[0]) {
            $slugNum[0] = 1;
        }

        return $slug2 . ($slugNum + 1);
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

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
use iuf\junia\model\Competition as ChildCompetition;
use iuf\junia\model\CompetitionQuery as ChildCompetitionQuery;
use iuf\junia\model\Event as ChildEvent;
use iuf\junia\model\EventQuery as ChildEventQuery;
use iuf\junia\model\Judge as ChildJudge;
use iuf\junia\model\JudgeQuery as ChildJudgeQuery;
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
use iuf\junia\model\Startgroup as ChildStartgroup;
use iuf\junia\model\StartgroupQuery as ChildStartgroupQuery;
use iuf\junia\model\Map\StartgroupTableMap;

/**
 * Base class that represents a row from the 'kk_junia_startgroup' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Startgroup implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\iuf\\junia\\model\\Map\\StartgroupTableMap';


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
     * The value for the competition_id field.
     * @var        int
     */
    protected $competition_id;

    /**
     * The value for the event_id field.
     * @var        int
     */
    protected $event_id;

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
     * @var        ChildCompetition
     */
    protected $aCompetition;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

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
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutines;
    protected $collRoutinesPartial;

    /**
     * @var        ObjectCollection|ChildJudge[] Collection to store aggregation of ChildJudge objects.
     */
    protected $collJudges;
    protected $collJudgesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildJudge[]
     */
    protected $judgesScheduledForDeletion = null;

    /**
     * Initializes internal state of iuf\junia\model\Base\Startgroup object.
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
     * Compares this with another <code>Startgroup</code> instance.  If
     * <code>obj</code> is an instance of <code>Startgroup</code>, delegates to
     * <code>equals(Startgroup)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Startgroup The current object, for fluid interface
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
     * Get the [competition_id] column value.
     *
     * @return int
     */
    public function getCompetitionId()
    {
        return $this->competition_id;
    }

    /**
     * Get the [event_id] column value.
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [competition_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setCompetitionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->competition_id !== $v) {
            $this->competition_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_COMPETITION_ID] = true;
        }

        if ($this->aCompetition !== null && $this->aCompetition->getId() !== $v) {
            $this->aCompetition = null;
        }

        return $this;
    } // setCompetitionId()

    /**
     * Set the value of [event_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_EVENT_ID] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getId() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    } // setEventId()

    /**
     * Set the value of [performance_total_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setPerformanceTotalStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_total_statistic_id !== $v) {
            $this->performance_total_statistic_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setPerformanceExecutionStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_execution_statistic_id !== $v) {
            $this->performance_execution_statistic_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setPerformanceChoreographyStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_choreography_statistic_id !== $v) {
            $this->performance_choreography_statistic_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function setPerformanceMusicAndTimingStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_music_and_timing_statistic_id !== $v) {
            $this->performance_music_and_timing_statistic_id = $v;
            $this->modifiedColumns[StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID] = true;
        }

        if ($this->aPerformanceMusicAndTimingStatistic !== null && $this->aPerformanceMusicAndTimingStatistic->getId() !== $v) {
            $this->aPerformanceMusicAndTimingStatistic = null;
        }

        return $this;
    } // setPerformanceMusicAndTimingStatisticId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StartgroupTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StartgroupTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StartgroupTableMap::translateFieldName('CompetitionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->competition_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StartgroupTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StartgroupTableMap::translateFieldName('PerformanceTotalStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_total_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StartgroupTableMap::translateFieldName('PerformanceExecutionStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_execution_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StartgroupTableMap::translateFieldName('PerformanceChoreographyStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_choreography_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StartgroupTableMap::translateFieldName('PerformanceMusicAndTimingStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_music_and_timing_statistic_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = StartgroupTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\iuf\\junia\\model\\Startgroup'), 0, $e);
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
        if ($this->aCompetition !== null && $this->competition_id !== $this->aCompetition->getId()) {
            $this->aCompetition = null;
        }
        if ($this->aEvent !== null && $this->event_id !== $this->aEvent->getId()) {
            $this->aEvent = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(StartgroupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStartgroupQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCompetition = null;
            $this->aEvent = null;
            $this->aPerformanceTotalStatistic = null;
            $this->aPerformanceExecutionStatistic = null;
            $this->aPerformanceChoreographyStatistic = null;
            $this->aPerformanceMusicAndTimingStatistic = null;
            $this->collRoutines = null;

            $this->collJudges = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Startgroup::setDeleted()
     * @see Startgroup::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStartgroupQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
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
                StartgroupTableMap::addInstanceToPool($this);
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

            if ($this->aCompetition !== null) {
                if ($this->aCompetition->isModified() || $this->aCompetition->isNew()) {
                    $affectedRows += $this->aCompetition->save($con);
                }
                $this->setCompetition($this->aCompetition);
            }

            if ($this->aEvent !== null) {
                if ($this->aEvent->isModified() || $this->aEvent->isNew()) {
                    $affectedRows += $this->aEvent->save($con);
                }
                $this->setEvent($this->aEvent);
            }

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

            if ($this->routinesScheduledForDeletion !== null) {
                if (!$this->routinesScheduledForDeletion->isEmpty()) {
                    \iuf\junia\model\RoutineQuery::create()
                        ->filterByPrimaryKeys($this->routinesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->routinesScheduledForDeletion = null;
                }
            }

            if ($this->collRoutines !== null) {
                foreach ($this->collRoutines as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->judgesScheduledForDeletion !== null) {
                if (!$this->judgesScheduledForDeletion->isEmpty()) {
                    \iuf\junia\model\JudgeQuery::create()
                        ->filterByPrimaryKeys($this->judgesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->judgesScheduledForDeletion = null;
                }
            }

            if ($this->collJudges !== null) {
                foreach ($this->collJudges as $referrerFK) {
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

        $this->modifiedColumns[StartgroupTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StartgroupTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StartgroupTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_COMPETITION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`competition_id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`event_id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_total_statistic_id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_execution_statistic_id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_choreography_statistic_id`';
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_music_and_timing_statistic_id`';
        }

        $sql = sprintf(
            'INSERT INTO `kk_junia_startgroup` (%s) VALUES (%s)',
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
                    case '`competition_id`':
                        $stmt->bindValue($identifier, $this->competition_id, PDO::PARAM_INT);
                        break;
                    case '`event_id`':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);
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
        $pos = StartgroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCompetitionId();
                break;
            case 3:
                return $this->getEventId();
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

        if (isset($alreadyDumpedObjects['Startgroup'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Startgroup'][$this->hashCode()] = true;
        $keys = StartgroupTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCompetitionId(),
            $keys[3] => $this->getEventId(),
            $keys[4] => $this->getPerformanceTotalStatisticId(),
            $keys[5] => $this->getPerformanceExecutionStatisticId(),
            $keys[6] => $this->getPerformanceChoreographyStatisticId(),
            $keys[7] => $this->getPerformanceMusicAndTimingStatisticId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCompetition) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'competition';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_competition';
                        break;
                    default:
                        $key = 'Competition';
                }

                $result[$key] = $this->aCompetition->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aEvent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'event';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_event';
                        break;
                    default:
                        $key = 'Event';
                }

                $result[$key] = $this->aEvent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collRoutines) {

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

                $result[$key] = $this->collRoutines->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJudges) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'judges';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_judges';
                        break;
                    default:
                        $key = 'Judges';
                }

                $result[$key] = $this->collJudges->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\iuf\junia\model\Startgroup
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StartgroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\iuf\junia\model\Startgroup
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
                $this->setCompetitionId($value);
                break;
            case 3:
                $this->setEventId($value);
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
        $keys = StartgroupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCompetitionId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEventId($arr[$keys[3]]);
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
     * @return $this|\iuf\junia\model\Startgroup The current object, for fluid interface
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
        $criteria = new Criteria(StartgroupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StartgroupTableMap::COL_ID)) {
            $criteria->add(StartgroupTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_NAME)) {
            $criteria->add(StartgroupTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_COMPETITION_ID)) {
            $criteria->add(StartgroupTableMap::COL_COMPETITION_ID, $this->competition_id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_EVENT_ID)) {
            $criteria->add(StartgroupTableMap::COL_EVENT_ID, $this->event_id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $criteria->add(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $this->performance_total_statistic_id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $criteria->add(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $this->performance_execution_statistic_id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $criteria->add(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $this->performance_choreography_statistic_id);
        }
        if ($this->isColumnModified(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $criteria->add(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $this->performance_music_and_timing_statistic_id);
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
        $criteria = ChildStartgroupQuery::create();
        $criteria->add(StartgroupTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \iuf\junia\model\Startgroup (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCompetitionId($this->getCompetitionId());
        $copyObj->setEventId($this->getEventId());
        $copyObj->setPerformanceTotalStatisticId($this->getPerformanceTotalStatisticId());
        $copyObj->setPerformanceExecutionStatisticId($this->getPerformanceExecutionStatisticId());
        $copyObj->setPerformanceChoreographyStatisticId($this->getPerformanceChoreographyStatisticId());
        $copyObj->setPerformanceMusicAndTimingStatisticId($this->getPerformanceMusicAndTimingStatisticId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRoutines() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutine($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJudges() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJudge($relObj->copy($deepCopy));
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
     * @return \iuf\junia\model\Startgroup Clone of current object.
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
     * Declares an association between this object and a ChildCompetition object.
     *
     * @param  ChildCompetition $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCompetition(ChildCompetition $v = null)
    {
        if ($v === null) {
            $this->setCompetitionId(NULL);
        } else {
            $this->setCompetitionId($v->getId());
        }

        $this->aCompetition = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCompetition object, it will not be re-added.
        if ($v !== null) {
            $v->addStartgroup($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCompetition object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCompetition The associated ChildCompetition object.
     * @throws PropelException
     */
    public function getCompetition(ConnectionInterface $con = null)
    {
        if ($this->aCompetition === null && ($this->competition_id !== null)) {
            $this->aCompetition = ChildCompetitionQuery::create()->findPk($this->competition_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCompetition->addStartgroups($this);
             */
        }

        return $this->aCompetition;
    }

    /**
     * Declares an association between this object and a ChildEvent object.
     *
     * @param  ChildEvent $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEvent(ChildEvent $v = null)
    {
        if ($v === null) {
            $this->setEventId(NULL);
        } else {
            $this->setEventId($v->getId());
        }

        $this->aEvent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEvent object, it will not be re-added.
        if ($v !== null) {
            $v->addStartgroup($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvent The associated ChildEvent object.
     * @throws PropelException
     */
    public function getEvent(ConnectionInterface $con = null)
    {
        if ($this->aEvent === null && ($this->event_id !== null)) {
            $this->aEvent = ChildEventQuery::create()->findPk($this->event_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvent->addStartgroups($this);
             */
        }

        return $this->aEvent;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
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
            $v->addStartgroupRelatedByPerformanceTotalStatisticId($this);
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
                $this->aPerformanceTotalStatistic->addStartgroupsRelatedByPerformanceTotalStatisticId($this);
             */
        }

        return $this->aPerformanceTotalStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
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
            $v->addStartgroupRelatedByPerformanceExecutionStatisticId($this);
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
                $this->aPerformanceExecutionStatistic->addStartgroupsRelatedByPerformanceExecutionStatisticId($this);
             */
        }

        return $this->aPerformanceExecutionStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
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
            $v->addStartgroupRelatedByPerformanceChoreographyStatisticId($this);
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
                $this->aPerformanceChoreographyStatistic->addStartgroupsRelatedByPerformanceChoreographyStatisticId($this);
             */
        }

        return $this->aPerformanceChoreographyStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
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
            $v->addStartgroupRelatedByPerformanceMusicAndTimingStatisticId($this);
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
                $this->aPerformanceMusicAndTimingStatistic->addStartgroupsRelatedByPerformanceMusicAndTimingStatisticId($this);
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
        if ('Routine' == $relationName) {
            return $this->initRoutines();
        }
        if ('Judge' == $relationName) {
            return $this->initJudges();
        }
    }

    /**
     * Clears out the collRoutines collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutines()
     */
    public function clearRoutines()
    {
        $this->collRoutines = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutines collection loaded partially.
     */
    public function resetPartialRoutines($v = true)
    {
        $this->collRoutinesPartial = $v;
    }

    /**
     * Initializes the collRoutines collection.
     *
     * By default this just sets the collRoutines collection to an empty array (like clearcollRoutines());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutines($overrideExisting = true)
    {
        if (null !== $this->collRoutines && !$overrideExisting) {
            return;
        }
        $this->collRoutines = new ObjectCollection();
        $this->collRoutines->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStartgroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutines(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesPartial && !$this->isNew();
        if (null === $this->collRoutines || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutines) {
                // return empty collection
                $this->initRoutines();
            } else {
                $collRoutines = ChildRoutineQuery::create(null, $criteria)
                    ->filterByStartgroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesPartial && count($collRoutines)) {
                        $this->initRoutines(false);

                        foreach ($collRoutines as $obj) {
                            if (false == $this->collRoutines->contains($obj)) {
                                $this->collRoutines->append($obj);
                            }
                        }

                        $this->collRoutinesPartial = true;
                    }

                    return $collRoutines;
                }

                if ($partial && $this->collRoutines) {
                    foreach ($this->collRoutines as $obj) {
                        if ($obj->isNew()) {
                            $collRoutines[] = $obj;
                        }
                    }
                }

                $this->collRoutines = $collRoutines;
                $this->collRoutinesPartial = false;
            }
        }

        return $this->collRoutines;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routines A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStartgroup The current object (for fluent API support)
     */
    public function setRoutines(Collection $routines, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesToDelete */
        $routinesToDelete = $this->getRoutines(new Criteria(), $con)->diff($routines);


        $this->routinesScheduledForDeletion = $routinesToDelete;

        foreach ($routinesToDelete as $routineRemoved) {
            $routineRemoved->setStartgroup(null);
        }

        $this->collRoutines = null;
        foreach ($routines as $routine) {
            $this->addRoutine($routine);
        }

        $this->collRoutines = $routines;
        $this->collRoutinesPartial = false;

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
    public function countRoutines(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesPartial && !$this->isNew();
        if (null === $this->collRoutines || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutines) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutines());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStartgroup($this)
                ->count($con);
        }

        return count($this->collRoutines);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function addRoutine(ChildRoutine $l)
    {
        if ($this->collRoutines === null) {
            $this->initRoutines();
            $this->collRoutinesPartial = true;
        }

        if (!$this->collRoutines->contains($l)) {
            $this->doAddRoutine($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routine The ChildRoutine object to add.
     */
    protected function doAddRoutine(ChildRoutine $routine)
    {
        $this->collRoutines[]= $routine;
        $routine->setStartgroup($this);
    }

    /**
     * @param  ChildRoutine $routine The ChildRoutine object to remove.
     * @return $this|ChildStartgroup The current object (for fluent API support)
     */
    public function removeRoutine(ChildRoutine $routine)
    {
        if ($this->getRoutines()->contains($routine)) {
            $pos = $this->collRoutines->search($routine);
            $this->collRoutines->remove($pos);
            if (null === $this->routinesScheduledForDeletion) {
                $this->routinesScheduledForDeletion = clone $this->collRoutines;
                $this->routinesScheduledForDeletion->clear();
            }
            $this->routinesScheduledForDeletion[]= clone $routine;
            $routine->setStartgroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Startgroup is new, it will return
     * an empty collection; or if this Startgroup has previously
     * been saved, it will retrieve related Routines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Startgroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesJoinPerformanceTotalStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('PerformanceTotalStatistic', $joinBehavior);

        return $this->getRoutines($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Startgroup is new, it will return
     * an empty collection; or if this Startgroup has previously
     * been saved, it will retrieve related Routines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Startgroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesJoinPerformanceExecutionStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('PerformanceExecutionStatistic', $joinBehavior);

        return $this->getRoutines($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Startgroup is new, it will return
     * an empty collection; or if this Startgroup has previously
     * been saved, it will retrieve related Routines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Startgroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesJoinPerformanceChoreographyStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('PerformanceChoreographyStatistic', $joinBehavior);

        return $this->getRoutines($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Startgroup is new, it will return
     * an empty collection; or if this Startgroup has previously
     * been saved, it will retrieve related Routines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Startgroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesJoinPerformanceMusicAndTimingStatistic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('PerformanceMusicAndTimingStatistic', $joinBehavior);

        return $this->getRoutines($query, $con);
    }

    /**
     * Clears out the collJudges collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addJudges()
     */
    public function clearJudges()
    {
        $this->collJudges = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collJudges collection loaded partially.
     */
    public function resetPartialJudges($v = true)
    {
        $this->collJudgesPartial = $v;
    }

    /**
     * Initializes the collJudges collection.
     *
     * By default this just sets the collJudges collection to an empty array (like clearcollJudges());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJudges($overrideExisting = true)
    {
        if (null !== $this->collJudges && !$overrideExisting) {
            return;
        }
        $this->collJudges = new ObjectCollection();
        $this->collJudges->setModel('\iuf\junia\model\Judge');
    }

    /**
     * Gets an array of ChildJudge objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStartgroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildJudge[] List of ChildJudge objects
     * @throws PropelException
     */
    public function getJudges(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collJudgesPartial && !$this->isNew();
        if (null === $this->collJudges || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJudges) {
                // return empty collection
                $this->initJudges();
            } else {
                $collJudges = ChildJudgeQuery::create(null, $criteria)
                    ->filterByStartgroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collJudgesPartial && count($collJudges)) {
                        $this->initJudges(false);

                        foreach ($collJudges as $obj) {
                            if (false == $this->collJudges->contains($obj)) {
                                $this->collJudges->append($obj);
                            }
                        }

                        $this->collJudgesPartial = true;
                    }

                    return $collJudges;
                }

                if ($partial && $this->collJudges) {
                    foreach ($this->collJudges as $obj) {
                        if ($obj->isNew()) {
                            $collJudges[] = $obj;
                        }
                    }
                }

                $this->collJudges = $collJudges;
                $this->collJudgesPartial = false;
            }
        }

        return $this->collJudges;
    }

    /**
     * Sets a collection of ChildJudge objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $judges A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStartgroup The current object (for fluent API support)
     */
    public function setJudges(Collection $judges, ConnectionInterface $con = null)
    {
        /** @var ChildJudge[] $judgesToDelete */
        $judgesToDelete = $this->getJudges(new Criteria(), $con)->diff($judges);


        $this->judgesScheduledForDeletion = $judgesToDelete;

        foreach ($judgesToDelete as $judgeRemoved) {
            $judgeRemoved->setStartgroup(null);
        }

        $this->collJudges = null;
        foreach ($judges as $judge) {
            $this->addJudge($judge);
        }

        $this->collJudges = $judges;
        $this->collJudgesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Judge objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Judge objects.
     * @throws PropelException
     */
    public function countJudges(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collJudgesPartial && !$this->isNew();
        if (null === $this->collJudges || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJudges) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJudges());
            }

            $query = ChildJudgeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStartgroup($this)
                ->count($con);
        }

        return count($this->collJudges);
    }

    /**
     * Method called to associate a ChildJudge object to this object
     * through the ChildJudge foreign key attribute.
     *
     * @param  ChildJudge $l ChildJudge
     * @return $this|\iuf\junia\model\Startgroup The current object (for fluent API support)
     */
    public function addJudge(ChildJudge $l)
    {
        if ($this->collJudges === null) {
            $this->initJudges();
            $this->collJudgesPartial = true;
        }

        if (!$this->collJudges->contains($l)) {
            $this->doAddJudge($l);
        }

        return $this;
    }

    /**
     * @param ChildJudge $judge The ChildJudge object to add.
     */
    protected function doAddJudge(ChildJudge $judge)
    {
        $this->collJudges[]= $judge;
        $judge->setStartgroup($this);
    }

    /**
     * @param  ChildJudge $judge The ChildJudge object to remove.
     * @return $this|ChildStartgroup The current object (for fluent API support)
     */
    public function removeJudge(ChildJudge $judge)
    {
        if ($this->getJudges()->contains($judge)) {
            $pos = $this->collJudges->search($judge);
            $this->collJudges->remove($pos);
            if (null === $this->judgesScheduledForDeletion) {
                $this->judgesScheduledForDeletion = clone $this->collJudges;
                $this->judgesScheduledForDeletion->clear();
            }
            $this->judgesScheduledForDeletion[]= clone $judge;
            $judge->setStartgroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Startgroup is new, it will return
     * an empty collection; or if this Startgroup has previously
     * been saved, it will retrieve related Judges from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Startgroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildJudge[] List of ChildJudge objects
     */
    public function getJudgesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildJudgeQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getJudges($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCompetition) {
            $this->aCompetition->removeStartgroup($this);
        }
        if (null !== $this->aEvent) {
            $this->aEvent->removeStartgroup($this);
        }
        if (null !== $this->aPerformanceTotalStatistic) {
            $this->aPerformanceTotalStatistic->removeStartgroupRelatedByPerformanceTotalStatisticId($this);
        }
        if (null !== $this->aPerformanceExecutionStatistic) {
            $this->aPerformanceExecutionStatistic->removeStartgroupRelatedByPerformanceExecutionStatisticId($this);
        }
        if (null !== $this->aPerformanceChoreographyStatistic) {
            $this->aPerformanceChoreographyStatistic->removeStartgroupRelatedByPerformanceChoreographyStatisticId($this);
        }
        if (null !== $this->aPerformanceMusicAndTimingStatistic) {
            $this->aPerformanceMusicAndTimingStatistic->removeStartgroupRelatedByPerformanceMusicAndTimingStatisticId($this);
        }
        $this->id = null;
        $this->name = null;
        $this->competition_id = null;
        $this->event_id = null;
        $this->performance_total_statistic_id = null;
        $this->performance_execution_statistic_id = null;
        $this->performance_choreography_statistic_id = null;
        $this->performance_music_and_timing_statistic_id = null;
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
            if ($this->collRoutines) {
                foreach ($this->collRoutines as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJudges) {
                foreach ($this->collJudges as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRoutines = null;
        $this->collJudges = null;
        $this->aCompetition = null;
        $this->aEvent = null;
        $this->aPerformanceTotalStatistic = null;
        $this->aPerformanceExecutionStatistic = null;
        $this->aPerformanceChoreographyStatistic = null;
        $this->aPerformanceMusicAndTimingStatistic = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StartgroupTableMap::DEFAULT_STRING_FORMAT);
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

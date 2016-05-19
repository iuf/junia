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
use iuf\junia\model\PerformanceScore as ChildPerformanceScore;
use iuf\junia\model\PerformanceScoreQuery as ChildPerformanceScoreQuery;
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
use iuf\junia\model\Score as ChildScore;
use iuf\junia\model\ScoreQuery as ChildScoreQuery;
use iuf\junia\model\Startgroup as ChildStartgroup;
use iuf\junia\model\StartgroupQuery as ChildStartgroupQuery;
use iuf\junia\model\Map\RoutineTableMap;

/**
 * Base class that represents a row from the 'kk_junia_routine' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Routine implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\iuf\\junia\\model\\Map\\RoutineTableMap';


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
     * The value for the startgroup_id field.
     * @var        int
     */
    protected $startgroup_id;

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
     * @var        ChildStartgroup
     */
    protected $aStartgroup;

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
     * @var        ObjectCollection|ChildScore[] Collection to store aggregation of ChildScore objects.
     */
    protected $collScores;
    protected $collScoresPartial;

    /**
     * @var        ObjectCollection|ChildPerformanceScore[] Collection to store aggregation of ChildPerformanceScore objects.
     */
    protected $collPerformanceScores;
    protected $collPerformanceScoresPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildScore[]
     */
    protected $scoresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPerformanceScore[]
     */
    protected $performanceScoresScheduledForDeletion = null;

    /**
     * Initializes internal state of iuf\junia\model\Base\Routine object.
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
     * Compares this with another <code>Routine</code> instance.  If
     * <code>obj</code> is an instance of <code>Routine</code>, delegates to
     * <code>equals(Routine)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Routine The current object, for fluid interface
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
     * Get the [startgroup_id] column value.
     *
     * @return int
     */
    public function getStartgroupId()
    {
        return $this->startgroup_id;
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
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[RoutineTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [startgroup_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setStartgroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->startgroup_id !== $v) {
            $this->startgroup_id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_STARTGROUP_ID] = true;
        }

        if ($this->aStartgroup !== null && $this->aStartgroup->getId() !== $v) {
            $this->aStartgroup = null;
        }

        return $this;
    } // setStartgroupId()

    /**
     * Set the value of [performance_total_statistic_id] column.
     *
     * @param int $v new value
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setPerformanceTotalStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_total_statistic_id !== $v) {
            $this->performance_total_statistic_id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setPerformanceExecutionStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_execution_statistic_id !== $v) {
            $this->performance_execution_statistic_id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setPerformanceChoreographyStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_choreography_statistic_id !== $v) {
            $this->performance_choreography_statistic_id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID] = true;
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
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function setPerformanceMusicAndTimingStatisticId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->performance_music_and_timing_statistic_id !== $v) {
            $this->performance_music_and_timing_statistic_id = $v;
            $this->modifiedColumns[RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RoutineTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RoutineTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RoutineTableMap::translateFieldName('StartgroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->startgroup_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RoutineTableMap::translateFieldName('PerformanceTotalStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_total_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RoutineTableMap::translateFieldName('PerformanceExecutionStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_execution_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RoutineTableMap::translateFieldName('PerformanceChoreographyStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_choreography_statistic_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RoutineTableMap::translateFieldName('PerformanceMusicAndTimingStatisticId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->performance_music_and_timing_statistic_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = RoutineTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\iuf\\junia\\model\\Routine'), 0, $e);
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
        if ($this->aStartgroup !== null && $this->startgroup_id !== $this->aStartgroup->getId()) {
            $this->aStartgroup = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(RoutineTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRoutineQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aStartgroup = null;
            $this->aPerformanceTotalStatistic = null;
            $this->aPerformanceExecutionStatistic = null;
            $this->aPerformanceChoreographyStatistic = null;
            $this->aPerformanceMusicAndTimingStatistic = null;
            $this->collScores = null;

            $this->collPerformanceScores = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Routine::setDeleted()
     * @see Routine::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoutineTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRoutineQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RoutineTableMap::DATABASE_NAME);
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
                RoutineTableMap::addInstanceToPool($this);
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

            if ($this->aStartgroup !== null) {
                if ($this->aStartgroup->isModified() || $this->aStartgroup->isNew()) {
                    $affectedRows += $this->aStartgroup->save($con);
                }
                $this->setStartgroup($this->aStartgroup);
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

            if ($this->scoresScheduledForDeletion !== null) {
                if (!$this->scoresScheduledForDeletion->isEmpty()) {
                    foreach ($this->scoresScheduledForDeletion as $score) {
                        // need to save related object because we set the relation to null
                        $score->save($con);
                    }
                    $this->scoresScheduledForDeletion = null;
                }
            }

            if ($this->collScores !== null) {
                foreach ($this->collScores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->performanceScoresScheduledForDeletion !== null) {
                if (!$this->performanceScoresScheduledForDeletion->isEmpty()) {
                    foreach ($this->performanceScoresScheduledForDeletion as $performanceScore) {
                        // need to save related object because we set the relation to null
                        $performanceScore->save($con);
                    }
                    $this->performanceScoresScheduledForDeletion = null;
                }
            }

            if ($this->collPerformanceScores !== null) {
                foreach ($this->collPerformanceScores as $referrerFK) {
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

        $this->modifiedColumns[RoutineTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RoutineTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RoutineTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_STARTGROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = '`startgroup_id`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_total_statistic_id`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_execution_statistic_id`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_choreography_statistic_id`';
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $modifiedColumns[':p' . $index++]  = '`performance_music_and_timing_statistic_id`';
        }

        $sql = sprintf(
            'INSERT INTO `kk_junia_routine` (%s) VALUES (%s)',
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
                    case '`startgroup_id`':
                        $stmt->bindValue($identifier, $this->startgroup_id, PDO::PARAM_INT);
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
        $pos = RoutineTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getStartgroupId();
                break;
            case 3:
                return $this->getPerformanceTotalStatisticId();
                break;
            case 4:
                return $this->getPerformanceExecutionStatisticId();
                break;
            case 5:
                return $this->getPerformanceChoreographyStatisticId();
                break;
            case 6:
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

        if (isset($alreadyDumpedObjects['Routine'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Routine'][$this->hashCode()] = true;
        $keys = RoutineTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getStartgroupId(),
            $keys[3] => $this->getPerformanceTotalStatisticId(),
            $keys[4] => $this->getPerformanceExecutionStatisticId(),
            $keys[5] => $this->getPerformanceChoreographyStatisticId(),
            $keys[6] => $this->getPerformanceMusicAndTimingStatisticId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aStartgroup) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'startgroup';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_startgroup';
                        break;
                    default:
                        $key = 'Startgroup';
                }

                $result[$key] = $this->aStartgroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collScores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'scores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_scores';
                        break;
                    default:
                        $key = 'Scores';
                }

                $result[$key] = $this->collScores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPerformanceScores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'performanceScores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'kk_junia_performance_scores';
                        break;
                    default:
                        $key = 'PerformanceScores';
                }

                $result[$key] = $this->collPerformanceScores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\iuf\junia\model\Routine
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RoutineTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\iuf\junia\model\Routine
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
                $this->setStartgroupId($value);
                break;
            case 3:
                $this->setPerformanceTotalStatisticId($value);
                break;
            case 4:
                $this->setPerformanceExecutionStatisticId($value);
                break;
            case 5:
                $this->setPerformanceChoreographyStatisticId($value);
                break;
            case 6:
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
        $keys = RoutineTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setStartgroupId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPerformanceTotalStatisticId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPerformanceExecutionStatisticId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPerformanceChoreographyStatisticId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPerformanceMusicAndTimingStatisticId($arr[$keys[6]]);
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
     * @return $this|\iuf\junia\model\Routine The current object, for fluid interface
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
        $criteria = new Criteria(RoutineTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RoutineTableMap::COL_ID)) {
            $criteria->add(RoutineTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_NAME)) {
            $criteria->add(RoutineTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_STARTGROUP_ID)) {
            $criteria->add(RoutineTableMap::COL_STARTGROUP_ID, $this->startgroup_id);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID)) {
            $criteria->add(RoutineTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, $this->performance_total_statistic_id);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID)) {
            $criteria->add(RoutineTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, $this->performance_execution_statistic_id);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID)) {
            $criteria->add(RoutineTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, $this->performance_choreography_statistic_id);
        }
        if ($this->isColumnModified(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID)) {
            $criteria->add(RoutineTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, $this->performance_music_and_timing_statistic_id);
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
        $criteria = ChildRoutineQuery::create();
        $criteria->add(RoutineTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \iuf\junia\model\Routine (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setStartgroupId($this->getStartgroupId());
        $copyObj->setPerformanceTotalStatisticId($this->getPerformanceTotalStatisticId());
        $copyObj->setPerformanceExecutionStatisticId($this->getPerformanceExecutionStatisticId());
        $copyObj->setPerformanceChoreographyStatisticId($this->getPerformanceChoreographyStatisticId());
        $copyObj->setPerformanceMusicAndTimingStatisticId($this->getPerformanceMusicAndTimingStatisticId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getScores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addScore($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPerformanceScores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPerformanceScore($relObj->copy($deepCopy));
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
     * @return \iuf\junia\model\Routine Clone of current object.
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
     * Declares an association between this object and a ChildStartgroup object.
     *
     * @param  ChildStartgroup $v
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStartgroup(ChildStartgroup $v = null)
    {
        if ($v === null) {
            $this->setStartgroupId(NULL);
        } else {
            $this->setStartgroupId($v->getId());
        }

        $this->aStartgroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStartgroup object, it will not be re-added.
        if ($v !== null) {
            $v->addRoutine($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStartgroup object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStartgroup The associated ChildStartgroup object.
     * @throws PropelException
     */
    public function getStartgroup(ConnectionInterface $con = null)
    {
        if ($this->aStartgroup === null && ($this->startgroup_id !== null)) {
            $this->aStartgroup = ChildStartgroupQuery::create()->findPk($this->startgroup_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStartgroup->addRoutines($this);
             */
        }

        return $this->aStartgroup;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
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
            $v->addRoutineRelatedByPerformanceTotalStatisticId($this);
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
                $this->aPerformanceTotalStatistic->addRoutinesRelatedByPerformanceTotalStatisticId($this);
             */
        }

        return $this->aPerformanceTotalStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
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
            $v->addRoutineRelatedByPerformanceExecutionStatisticId($this);
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
                $this->aPerformanceExecutionStatistic->addRoutinesRelatedByPerformanceExecutionStatisticId($this);
             */
        }

        return $this->aPerformanceExecutionStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
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
            $v->addRoutineRelatedByPerformanceChoreographyStatisticId($this);
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
                $this->aPerformanceChoreographyStatistic->addRoutinesRelatedByPerformanceChoreographyStatisticId($this);
             */
        }

        return $this->aPerformanceChoreographyStatistic;
    }

    /**
     * Declares an association between this object and a ChildPerformanceStatistic object.
     *
     * @param  ChildPerformanceStatistic $v
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
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
            $v->addRoutineRelatedByPerformanceMusicAndTimingStatisticId($this);
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
                $this->aPerformanceMusicAndTimingStatistic->addRoutinesRelatedByPerformanceMusicAndTimingStatisticId($this);
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
        if ('Score' == $relationName) {
            return $this->initScores();
        }
        if ('PerformanceScore' == $relationName) {
            return $this->initPerformanceScores();
        }
    }

    /**
     * Clears out the collScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addScores()
     */
    public function clearScores()
    {
        $this->collScores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collScores collection loaded partially.
     */
    public function resetPartialScores($v = true)
    {
        $this->collScoresPartial = $v;
    }

    /**
     * Initializes the collScores collection.
     *
     * By default this just sets the collScores collection to an empty array (like clearcollScores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initScores($overrideExisting = true)
    {
        if (null !== $this->collScores && !$overrideExisting) {
            return;
        }
        $this->collScores = new ObjectCollection();
        $this->collScores->setModel('\iuf\junia\model\Score');
    }

    /**
     * Gets an array of ChildScore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRoutine is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildScore[] List of ChildScore objects
     * @throws PropelException
     */
    public function getScores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collScoresPartial && !$this->isNew();
        if (null === $this->collScores || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collScores) {
                // return empty collection
                $this->initScores();
            } else {
                $collScores = ChildScoreQuery::create(null, $criteria)
                    ->filterByRoutine($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collScoresPartial && count($collScores)) {
                        $this->initScores(false);

                        foreach ($collScores as $obj) {
                            if (false == $this->collScores->contains($obj)) {
                                $this->collScores->append($obj);
                            }
                        }

                        $this->collScoresPartial = true;
                    }

                    return $collScores;
                }

                if ($partial && $this->collScores) {
                    foreach ($this->collScores as $obj) {
                        if ($obj->isNew()) {
                            $collScores[] = $obj;
                        }
                    }
                }

                $this->collScores = $collScores;
                $this->collScoresPartial = false;
            }
        }

        return $this->collScores;
    }

    /**
     * Sets a collection of ChildScore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $scores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRoutine The current object (for fluent API support)
     */
    public function setScores(Collection $scores, ConnectionInterface $con = null)
    {
        /** @var ChildScore[] $scoresToDelete */
        $scoresToDelete = $this->getScores(new Criteria(), $con)->diff($scores);


        $this->scoresScheduledForDeletion = $scoresToDelete;

        foreach ($scoresToDelete as $scoreRemoved) {
            $scoreRemoved->setRoutine(null);
        }

        $this->collScores = null;
        foreach ($scores as $score) {
            $this->addScore($score);
        }

        $this->collScores = $scores;
        $this->collScoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Score objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Score objects.
     * @throws PropelException
     */
    public function countScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collScoresPartial && !$this->isNew();
        if (null === $this->collScores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collScores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getScores());
            }

            $query = ChildScoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRoutine($this)
                ->count($con);
        }

        return count($this->collScores);
    }

    /**
     * Method called to associate a ChildScore object to this object
     * through the ChildScore foreign key attribute.
     *
     * @param  ChildScore $l ChildScore
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function addScore(ChildScore $l)
    {
        if ($this->collScores === null) {
            $this->initScores();
            $this->collScoresPartial = true;
        }

        if (!$this->collScores->contains($l)) {
            $this->doAddScore($l);
        }

        return $this;
    }

    /**
     * @param ChildScore $score The ChildScore object to add.
     */
    protected function doAddScore(ChildScore $score)
    {
        $this->collScores[]= $score;
        $score->setRoutine($this);
    }

    /**
     * @param  ChildScore $score The ChildScore object to remove.
     * @return $this|ChildRoutine The current object (for fluent API support)
     */
    public function removeScore(ChildScore $score)
    {
        if ($this->getScores()->contains($score)) {
            $pos = $this->collScores->search($score);
            $this->collScores->remove($pos);
            if (null === $this->scoresScheduledForDeletion) {
                $this->scoresScheduledForDeletion = clone $this->collScores;
                $this->scoresScheduledForDeletion->clear();
            }
            $this->scoresScheduledForDeletion[]= $score;
            $score->setRoutine(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Routine is new, it will return
     * an empty collection; or if this Routine has previously
     * been saved, it will retrieve related Scores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Routine.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildScore[] List of ChildScore objects
     */
    public function getScoresJoinJudge(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildScoreQuery::create(null, $criteria);
        $query->joinWith('Judge', $joinBehavior);

        return $this->getScores($query, $con);
    }

    /**
     * Clears out the collPerformanceScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPerformanceScores()
     */
    public function clearPerformanceScores()
    {
        $this->collPerformanceScores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPerformanceScores collection loaded partially.
     */
    public function resetPartialPerformanceScores($v = true)
    {
        $this->collPerformanceScoresPartial = $v;
    }

    /**
     * Initializes the collPerformanceScores collection.
     *
     * By default this just sets the collPerformanceScores collection to an empty array (like clearcollPerformanceScores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPerformanceScores($overrideExisting = true)
    {
        if (null !== $this->collPerformanceScores && !$overrideExisting) {
            return;
        }
        $this->collPerformanceScores = new ObjectCollection();
        $this->collPerformanceScores->setModel('\iuf\junia\model\PerformanceScore');
    }

    /**
     * Gets an array of ChildPerformanceScore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRoutine is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPerformanceScore[] List of ChildPerformanceScore objects
     * @throws PropelException
     */
    public function getPerformanceScores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPerformanceScoresPartial && !$this->isNew();
        if (null === $this->collPerformanceScores || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPerformanceScores) {
                // return empty collection
                $this->initPerformanceScores();
            } else {
                $collPerformanceScores = ChildPerformanceScoreQuery::create(null, $criteria)
                    ->filterByRoutine($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPerformanceScoresPartial && count($collPerformanceScores)) {
                        $this->initPerformanceScores(false);

                        foreach ($collPerformanceScores as $obj) {
                            if (false == $this->collPerformanceScores->contains($obj)) {
                                $this->collPerformanceScores->append($obj);
                            }
                        }

                        $this->collPerformanceScoresPartial = true;
                    }

                    return $collPerformanceScores;
                }

                if ($partial && $this->collPerformanceScores) {
                    foreach ($this->collPerformanceScores as $obj) {
                        if ($obj->isNew()) {
                            $collPerformanceScores[] = $obj;
                        }
                    }
                }

                $this->collPerformanceScores = $collPerformanceScores;
                $this->collPerformanceScoresPartial = false;
            }
        }

        return $this->collPerformanceScores;
    }

    /**
     * Sets a collection of ChildPerformanceScore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $performanceScores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRoutine The current object (for fluent API support)
     */
    public function setPerformanceScores(Collection $performanceScores, ConnectionInterface $con = null)
    {
        /** @var ChildPerformanceScore[] $performanceScoresToDelete */
        $performanceScoresToDelete = $this->getPerformanceScores(new Criteria(), $con)->diff($performanceScores);


        $this->performanceScoresScheduledForDeletion = $performanceScoresToDelete;

        foreach ($performanceScoresToDelete as $performanceScoreRemoved) {
            $performanceScoreRemoved->setRoutine(null);
        }

        $this->collPerformanceScores = null;
        foreach ($performanceScores as $performanceScore) {
            $this->addPerformanceScore($performanceScore);
        }

        $this->collPerformanceScores = $performanceScores;
        $this->collPerformanceScoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PerformanceScore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PerformanceScore objects.
     * @throws PropelException
     */
    public function countPerformanceScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPerformanceScoresPartial && !$this->isNew();
        if (null === $this->collPerformanceScores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPerformanceScores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPerformanceScores());
            }

            $query = ChildPerformanceScoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRoutine($this)
                ->count($con);
        }

        return count($this->collPerformanceScores);
    }

    /**
     * Method called to associate a ChildPerformanceScore object to this object
     * through the ChildPerformanceScore foreign key attribute.
     *
     * @param  ChildPerformanceScore $l ChildPerformanceScore
     * @return $this|\iuf\junia\model\Routine The current object (for fluent API support)
     */
    public function addPerformanceScore(ChildPerformanceScore $l)
    {
        if ($this->collPerformanceScores === null) {
            $this->initPerformanceScores();
            $this->collPerformanceScoresPartial = true;
        }

        if (!$this->collPerformanceScores->contains($l)) {
            $this->doAddPerformanceScore($l);
        }

        return $this;
    }

    /**
     * @param ChildPerformanceScore $performanceScore The ChildPerformanceScore object to add.
     */
    protected function doAddPerformanceScore(ChildPerformanceScore $performanceScore)
    {
        $this->collPerformanceScores[]= $performanceScore;
        $performanceScore->setRoutine($this);
    }

    /**
     * @param  ChildPerformanceScore $performanceScore The ChildPerformanceScore object to remove.
     * @return $this|ChildRoutine The current object (for fluent API support)
     */
    public function removePerformanceScore(ChildPerformanceScore $performanceScore)
    {
        if ($this->getPerformanceScores()->contains($performanceScore)) {
            $pos = $this->collPerformanceScores->search($performanceScore);
            $this->collPerformanceScores->remove($pos);
            if (null === $this->performanceScoresScheduledForDeletion) {
                $this->performanceScoresScheduledForDeletion = clone $this->collPerformanceScores;
                $this->performanceScoresScheduledForDeletion->clear();
            }
            $this->performanceScoresScheduledForDeletion[]= $performanceScore;
            $performanceScore->setRoutine(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Routine is new, it will return
     * an empty collection; or if this Routine has previously
     * been saved, it will retrieve related PerformanceScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Routine.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPerformanceScore[] List of ChildPerformanceScore objects
     */
    public function getPerformanceScoresJoinScore(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPerformanceScoreQuery::create(null, $criteria);
        $query->joinWith('Score', $joinBehavior);

        return $this->getPerformanceScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Routine is new, it will return
     * an empty collection; or if this Routine has previously
     * been saved, it will retrieve related PerformanceScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Routine.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPerformanceScore[] List of ChildPerformanceScore objects
     */
    public function getPerformanceScoresJoinJudge(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPerformanceScoreQuery::create(null, $criteria);
        $query->joinWith('Judge', $joinBehavior);

        return $this->getPerformanceScores($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aStartgroup) {
            $this->aStartgroup->removeRoutine($this);
        }
        if (null !== $this->aPerformanceTotalStatistic) {
            $this->aPerformanceTotalStatistic->removeRoutineRelatedByPerformanceTotalStatisticId($this);
        }
        if (null !== $this->aPerformanceExecutionStatistic) {
            $this->aPerformanceExecutionStatistic->removeRoutineRelatedByPerformanceExecutionStatisticId($this);
        }
        if (null !== $this->aPerformanceChoreographyStatistic) {
            $this->aPerformanceChoreographyStatistic->removeRoutineRelatedByPerformanceChoreographyStatisticId($this);
        }
        if (null !== $this->aPerformanceMusicAndTimingStatistic) {
            $this->aPerformanceMusicAndTimingStatistic->removeRoutineRelatedByPerformanceMusicAndTimingStatisticId($this);
        }
        $this->id = null;
        $this->name = null;
        $this->startgroup_id = null;
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
            if ($this->collScores) {
                foreach ($this->collScores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPerformanceScores) {
                foreach ($this->collPerformanceScores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collScores = null;
        $this->collPerformanceScores = null;
        $this->aStartgroup = null;
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
        return (string) $this->exportTo(RoutineTableMap::DEFAULT_STRING_FORMAT);
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

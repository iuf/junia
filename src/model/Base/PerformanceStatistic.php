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
use iuf\junia\model\PerformanceStatistic as ChildPerformanceStatistic;
use iuf\junia\model\PerformanceStatisticQuery as ChildPerformanceStatisticQuery;
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
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
     * The value for the average field.
     * @var        double
     */
    protected $average;

    /**
     * The value for the standard_deviation field.
     * @var        double
     */
    protected $standard_deviation;

    /**
     * The value for the variance field.
     * @var        double
     */
    protected $variance;

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
     * Get the [average] column value.
     *
     * @return double
     */
    public function getAverage()
    {
        return $this->average;
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
     * Get the [variance] column value.
     *
     * @return double
     */
    public function getVariance()
    {
        return $this->variance;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PerformanceStatisticTableMap::translateFieldName('Average', TableMap::TYPE_PHPNAME, $indexType)];
            $this->average = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PerformanceStatisticTableMap::translateFieldName('StandardDeviation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->standard_deviation = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PerformanceStatisticTableMap::translateFieldName('Variance', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variance = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PerformanceStatisticTableMap::NUM_HYDRATE_COLUMNS.

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
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_AVERAGE)) {
            $modifiedColumns[':p' . $index++]  = '`average`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION)) {
            $modifiedColumns[':p' . $index++]  = '`standard_deviation`';
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIANCE)) {
            $modifiedColumns[':p' . $index++]  = '`variance`';
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
                    case '`average`':
                        $stmt->bindValue($identifier, $this->average, PDO::PARAM_STR);
                        break;
                    case '`standard_deviation`':
                        $stmt->bindValue($identifier, $this->standard_deviation, PDO::PARAM_STR);
                        break;
                    case '`variance`':
                        $stmt->bindValue($identifier, $this->variance, PDO::PARAM_STR);
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
                return $this->getAverage();
                break;
            case 5:
                return $this->getStandardDeviation();
                break;
            case 6:
                return $this->getVariance();
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
            $keys[4] => $this->getAverage(),
            $keys[5] => $this->getStandardDeviation(),
            $keys[6] => $this->getVariance(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
                $this->setAverage($value);
                break;
            case 5:
                $this->setStandardDeviation($value);
                break;
            case 6:
                $this->setVariance($value);
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
            $this->setAverage($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStandardDeviation($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setVariance($arr[$keys[6]]);
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
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_AVERAGE)) {
            $criteria->add(PerformanceStatisticTableMap::COL_AVERAGE, $this->average);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION)) {
            $criteria->add(PerformanceStatisticTableMap::COL_STANDARD_DEVIATION, $this->standard_deviation);
        }
        if ($this->isColumnModified(PerformanceStatisticTableMap::COL_VARIANCE)) {
            $criteria->add(PerformanceStatisticTableMap::COL_VARIANCE, $this->variance);
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
        $copyObj->setAverage($this->getAverage());
        $copyObj->setStandardDeviation($this->getStandardDeviation());
        $copyObj->setVariance($this->getVariance());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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
        $this->average = null;
        $this->standard_deviation = null;
        $this->variance = null;
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

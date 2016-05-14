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
use iuf\junia\model\PerformanceStatistics as ChildPerformanceStatistics;
use iuf\junia\model\PerformanceStatisticsQuery as ChildPerformanceStatisticsQuery;
use iuf\junia\model\Routine as ChildRoutine;
use iuf\junia\model\RoutineQuery as ChildRoutineQuery;
use iuf\junia\model\Map\PerformanceStatisticsTableMap;

/**
 * Base class that represents a row from the 'kk_junia_performance_statistics' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class PerformanceStatistics implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\iuf\\junia\\model\\Map\\PerformanceStatisticsTableMap';


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
    protected $collRoutinesRelatedByPerformanceTotalStatisticsId;
    protected $collRoutinesRelatedByPerformanceTotalStatisticsIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceExecutionStatisticsId;
    protected $collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceChoreographyStatisticsId;
    protected $collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial;

    /**
     * @var        ObjectCollection|ChildRoutine[] Collection to store aggregation of ChildRoutine objects.
     */
    protected $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId;
    protected $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial;

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
    protected $routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRoutine[]
     */
    protected $routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion = null;

    /**
     * Initializes internal state of iuf\junia\model\Base\PerformanceStatistics object.
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
     * Compares this with another <code>PerformanceStatistics</code> instance.  If
     * <code>obj</code> is an instance of <code>PerformanceStatistics</code>, delegates to
     * <code>equals(PerformanceStatistics)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|PerformanceStatistics The current object, for fluid interface
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
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [min] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setMin($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->min !== $v) {
            $this->min = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_MIN] = true;
        }

        return $this;
    } // setMin()

    /**
     * Set the value of [max] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setMax($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->max !== $v) {
            $this->max = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_MAX] = true;
        }

        return $this;
    } // setMax()

    /**
     * Set the value of [range] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setRange($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->range !== $v) {
            $this->range = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_RANGE] = true;
        }

        return $this;
    } // setRange()

    /**
     * Set the value of [average] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setAverage($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->average !== $v) {
            $this->average = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_AVERAGE] = true;
        }

        return $this;
    } // setAverage()

    /**
     * Set the value of [standard_deviation] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setStandardDeviation($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->standard_deviation !== $v) {
            $this->standard_deviation = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION] = true;
        }

        return $this;
    } // setStandardDeviation()

    /**
     * Set the value of [variance] column.
     *
     * @param double $v new value
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function setVariance($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->variance !== $v) {
            $this->variance = $v;
            $this->modifiedColumns[PerformanceStatisticsTableMap::COL_VARIANCE] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Min', TableMap::TYPE_PHPNAME, $indexType)];
            $this->min = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Max', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Range', TableMap::TYPE_PHPNAME, $indexType)];
            $this->range = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Average', TableMap::TYPE_PHPNAME, $indexType)];
            $this->average = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PerformanceStatisticsTableMap::translateFieldName('StandardDeviation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->standard_deviation = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PerformanceStatisticsTableMap::translateFieldName('Variance', TableMap::TYPE_PHPNAME, $indexType)];
            $this->variance = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PerformanceStatisticsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\iuf\\junia\\model\\PerformanceStatistics'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPerformanceStatisticsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRoutinesRelatedByPerformanceTotalStatisticsId = null;

            $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = null;

            $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = null;

            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PerformanceStatistics::setDeleted()
     * @see PerformanceStatistics::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPerformanceStatisticsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceStatisticsTableMap::DATABASE_NAME);
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
                PerformanceStatisticsTableMap::addInstanceToPool($this);
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

            if ($this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion as $routineRelatedByPerformanceTotalStatisticsId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceTotalStatisticsId->save($con);
                    }
                    $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceTotalStatisticsId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticsId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion as $routineRelatedByPerformanceExecutionStatisticsId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceExecutionStatisticsId->save($con);
                    }
                    $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion as $routineRelatedByPerformanceChoreographyStatisticsId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceChoreographyStatisticsId->save($con);
                    }
                    $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion !== null) {
                if (!$this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion as $routineRelatedByPerformanceMusicAndTimingStatisticsId) {
                        // need to save related object because we set the relation to null
                        $routineRelatedByPerformanceMusicAndTimingStatisticsId->save($con);
                    }
                    $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion = null;
                }
            }

            if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId !== null) {
                foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId as $referrerFK) {
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

        $this->modifiedColumns[PerformanceStatisticsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PerformanceStatisticsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_MIN)) {
            $modifiedColumns[':p' . $index++]  = '`min`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_MAX)) {
            $modifiedColumns[':p' . $index++]  = '`max`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_RANGE)) {
            $modifiedColumns[':p' . $index++]  = '`range`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_AVERAGE)) {
            $modifiedColumns[':p' . $index++]  = '`average`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION)) {
            $modifiedColumns[':p' . $index++]  = '`standard_deviation`';
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_VARIANCE)) {
            $modifiedColumns[':p' . $index++]  = '`variance`';
        }

        $sql = sprintf(
            'INSERT INTO `kk_junia_performance_statistics` (%s) VALUES (%s)',
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
        $pos = PerformanceStatisticsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['PerformanceStatistics'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PerformanceStatistics'][$this->hashCode()] = true;
        $keys = PerformanceStatisticsTableMap::getFieldNames($keyType);
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
            if (null !== $this->collRoutinesRelatedByPerformanceTotalStatisticsId) {

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

                $result[$key] = $this->collRoutinesRelatedByPerformanceTotalStatisticsId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceExecutionStatisticsId) {

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

                $result[$key] = $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId) {

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

                $result[$key] = $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId) {

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

                $result[$key] = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\iuf\junia\model\PerformanceStatistics
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PerformanceStatisticsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\iuf\junia\model\PerformanceStatistics
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
        $keys = PerformanceStatisticsTableMap::getFieldNames($keyType);

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
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object, for fluid interface
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
        $criteria = new Criteria(PerformanceStatisticsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_ID)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_MIN)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_MIN, $this->min);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_MAX)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_MAX, $this->max);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_RANGE)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_RANGE, $this->range);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_AVERAGE)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_AVERAGE, $this->average);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_STANDARD_DEVIATION, $this->standard_deviation);
        }
        if ($this->isColumnModified(PerformanceStatisticsTableMap::COL_VARIANCE)) {
            $criteria->add(PerformanceStatisticsTableMap::COL_VARIANCE, $this->variance);
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
        $criteria = ChildPerformanceStatisticsQuery::create();
        $criteria->add(PerformanceStatisticsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \iuf\junia\model\PerformanceStatistics (or compatible) type.
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

            foreach ($this->getRoutinesRelatedByPerformanceTotalStatisticsId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceTotalStatisticsId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceExecutionStatisticsId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceExecutionStatisticsId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceChoreographyStatisticsId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceChoreographyStatisticsId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRoutineRelatedByPerformanceMusicAndTimingStatisticsId($relObj->copy($deepCopy));
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
     * @return \iuf\junia\model\PerformanceStatistics Clone of current object.
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
        if ('RoutineRelatedByPerformanceTotalStatisticsId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceTotalStatisticsId();
        }
        if ('RoutineRelatedByPerformanceExecutionStatisticsId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceExecutionStatisticsId();
        }
        if ('RoutineRelatedByPerformanceChoreographyStatisticsId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceChoreographyStatisticsId();
        }
        if ('RoutineRelatedByPerformanceMusicAndTimingStatisticsId' == $relationName) {
            return $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticsId();
        }
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceTotalStatisticsId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceTotalStatisticsId()
     */
    public function clearRoutinesRelatedByPerformanceTotalStatisticsId()
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticsId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceTotalStatisticsId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceTotalStatisticsId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceTotalStatisticsId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceTotalStatisticsId collection to an empty array (like clearcollRoutinesRelatedByPerformanceTotalStatisticsId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceTotalStatisticsId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceTotalStatisticsId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceTotalStatisticsId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceTotalStatisticsId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistics is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceTotalStatisticsId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceTotalStatisticsId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceTotalStatisticsId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceTotalStatisticsId();
            } else {
                $collRoutinesRelatedByPerformanceTotalStatisticsId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceStatisticsRelatedByPerformanceTotalStatisticsId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial && count($collRoutinesRelatedByPerformanceTotalStatisticsId)) {
                        $this->initRoutinesRelatedByPerformanceTotalStatisticsId(false);

                        foreach ($collRoutinesRelatedByPerformanceTotalStatisticsId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceTotalStatisticsId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceTotalStatisticsId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceTotalStatisticsId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceTotalStatisticsId) {
                    foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticsId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceTotalStatisticsId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceTotalStatisticsId = $collRoutinesRelatedByPerformanceTotalStatisticsId;
                $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceTotalStatisticsId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceTotalStatisticsId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceTotalStatisticsId(Collection $routinesRelatedByPerformanceTotalStatisticsId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceTotalStatisticsIdToDelete */
        $routinesRelatedByPerformanceTotalStatisticsIdToDelete = $this->getRoutinesRelatedByPerformanceTotalStatisticsId(new Criteria(), $con)->diff($routinesRelatedByPerformanceTotalStatisticsId);


        $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion = $routinesRelatedByPerformanceTotalStatisticsIdToDelete;

        foreach ($routinesRelatedByPerformanceTotalStatisticsIdToDelete as $routineRelatedByPerformanceTotalStatisticsIdRemoved) {
            $routineRelatedByPerformanceTotalStatisticsIdRemoved->setPerformanceStatisticsRelatedByPerformanceTotalStatisticsId(null);
        }

        $this->collRoutinesRelatedByPerformanceTotalStatisticsId = null;
        foreach ($routinesRelatedByPerformanceTotalStatisticsId as $routineRelatedByPerformanceTotalStatisticsId) {
            $this->addRoutineRelatedByPerformanceTotalStatisticsId($routineRelatedByPerformanceTotalStatisticsId);
        }

        $this->collRoutinesRelatedByPerformanceTotalStatisticsId = $routinesRelatedByPerformanceTotalStatisticsId;
        $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial = false;

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
    public function countRoutinesRelatedByPerformanceTotalStatisticsId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceTotalStatisticsId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceTotalStatisticsId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceTotalStatisticsId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceStatisticsRelatedByPerformanceTotalStatisticsId($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceTotalStatisticsId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceTotalStatisticsId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceTotalStatisticsId === null) {
            $this->initRoutinesRelatedByPerformanceTotalStatisticsId();
            $this->collRoutinesRelatedByPerformanceTotalStatisticsIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceTotalStatisticsId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceTotalStatisticsId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceTotalStatisticsId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceTotalStatisticsId(ChildRoutine $routineRelatedByPerformanceTotalStatisticsId)
    {
        $this->collRoutinesRelatedByPerformanceTotalStatisticsId[]= $routineRelatedByPerformanceTotalStatisticsId;
        $routineRelatedByPerformanceTotalStatisticsId->setPerformanceStatisticsRelatedByPerformanceTotalStatisticsId($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceTotalStatisticsId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceTotalStatisticsId(ChildRoutine $routineRelatedByPerformanceTotalStatisticsId)
    {
        if ($this->getRoutinesRelatedByPerformanceTotalStatisticsId()->contains($routineRelatedByPerformanceTotalStatisticsId)) {
            $pos = $this->collRoutinesRelatedByPerformanceTotalStatisticsId->search($routineRelatedByPerformanceTotalStatisticsId);
            $this->collRoutinesRelatedByPerformanceTotalStatisticsId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceTotalStatisticsId;
                $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceTotalStatisticsIdScheduledForDeletion[]= $routineRelatedByPerformanceTotalStatisticsId;
            $routineRelatedByPerformanceTotalStatisticsId->setPerformanceStatisticsRelatedByPerformanceTotalStatisticsId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistics is new, it will return
     * an empty collection; or if this PerformanceStatistics has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceTotalStatisticsId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistics.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceTotalStatisticsIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceTotalStatisticsId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceExecutionStatisticsId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceExecutionStatisticsId()
     */
    public function clearRoutinesRelatedByPerformanceExecutionStatisticsId()
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceExecutionStatisticsId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceExecutionStatisticsId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceExecutionStatisticsId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceExecutionStatisticsId collection to an empty array (like clearcollRoutinesRelatedByPerformanceExecutionStatisticsId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceExecutionStatisticsId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceExecutionStatisticsId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistics is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceExecutionStatisticsId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceExecutionStatisticsId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceExecutionStatisticsId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceExecutionStatisticsId();
            } else {
                $collRoutinesRelatedByPerformanceExecutionStatisticsId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceStatisticsRelatedByPerformanceExecutionStatisticsId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial && count($collRoutinesRelatedByPerformanceExecutionStatisticsId)) {
                        $this->initRoutinesRelatedByPerformanceExecutionStatisticsId(false);

                        foreach ($collRoutinesRelatedByPerformanceExecutionStatisticsId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceExecutionStatisticsId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceExecutionStatisticsId) {
                    foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceExecutionStatisticsId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = $collRoutinesRelatedByPerformanceExecutionStatisticsId;
                $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceExecutionStatisticsId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceExecutionStatisticsId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceExecutionStatisticsId(Collection $routinesRelatedByPerformanceExecutionStatisticsId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceExecutionStatisticsIdToDelete */
        $routinesRelatedByPerformanceExecutionStatisticsIdToDelete = $this->getRoutinesRelatedByPerformanceExecutionStatisticsId(new Criteria(), $con)->diff($routinesRelatedByPerformanceExecutionStatisticsId);


        $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion = $routinesRelatedByPerformanceExecutionStatisticsIdToDelete;

        foreach ($routinesRelatedByPerformanceExecutionStatisticsIdToDelete as $routineRelatedByPerformanceExecutionStatisticsIdRemoved) {
            $routineRelatedByPerformanceExecutionStatisticsIdRemoved->setPerformanceStatisticsRelatedByPerformanceExecutionStatisticsId(null);
        }

        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = null;
        foreach ($routinesRelatedByPerformanceExecutionStatisticsId as $routineRelatedByPerformanceExecutionStatisticsId) {
            $this->addRoutineRelatedByPerformanceExecutionStatisticsId($routineRelatedByPerformanceExecutionStatisticsId);
        }

        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = $routinesRelatedByPerformanceExecutionStatisticsId;
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial = false;

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
    public function countRoutinesRelatedByPerformanceExecutionStatisticsId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceExecutionStatisticsId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceExecutionStatisticsId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceExecutionStatisticsId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceStatisticsRelatedByPerformanceExecutionStatisticsId($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceExecutionStatisticsId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceExecutionStatisticsId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId === null) {
            $this->initRoutinesRelatedByPerformanceExecutionStatisticsId();
            $this->collRoutinesRelatedByPerformanceExecutionStatisticsIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceExecutionStatisticsId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceExecutionStatisticsId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceExecutionStatisticsId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceExecutionStatisticsId(ChildRoutine $routineRelatedByPerformanceExecutionStatisticsId)
    {
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId[]= $routineRelatedByPerformanceExecutionStatisticsId;
        $routineRelatedByPerformanceExecutionStatisticsId->setPerformanceStatisticsRelatedByPerformanceExecutionStatisticsId($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceExecutionStatisticsId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceExecutionStatisticsId(ChildRoutine $routineRelatedByPerformanceExecutionStatisticsId)
    {
        if ($this->getRoutinesRelatedByPerformanceExecutionStatisticsId()->contains($routineRelatedByPerformanceExecutionStatisticsId)) {
            $pos = $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->search($routineRelatedByPerformanceExecutionStatisticsId);
            $this->collRoutinesRelatedByPerformanceExecutionStatisticsId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceExecutionStatisticsId;
                $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceExecutionStatisticsIdScheduledForDeletion[]= $routineRelatedByPerformanceExecutionStatisticsId;
            $routineRelatedByPerformanceExecutionStatisticsId->setPerformanceStatisticsRelatedByPerformanceExecutionStatisticsId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistics is new, it will return
     * an empty collection; or if this PerformanceStatistics has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceExecutionStatisticsId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistics.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceExecutionStatisticsIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceExecutionStatisticsId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceChoreographyStatisticsId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceChoreographyStatisticsId()
     */
    public function clearRoutinesRelatedByPerformanceChoreographyStatisticsId()
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceChoreographyStatisticsId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceChoreographyStatisticsId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceChoreographyStatisticsId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceChoreographyStatisticsId collection to an empty array (like clearcollRoutinesRelatedByPerformanceChoreographyStatisticsId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceChoreographyStatisticsId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistics is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceChoreographyStatisticsId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceChoreographyStatisticsId();
            } else {
                $collRoutinesRelatedByPerformanceChoreographyStatisticsId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceStatisticsRelatedByPerformanceChoreographyStatisticsId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial && count($collRoutinesRelatedByPerformanceChoreographyStatisticsId)) {
                        $this->initRoutinesRelatedByPerformanceChoreographyStatisticsId(false);

                        foreach ($collRoutinesRelatedByPerformanceChoreographyStatisticsId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceChoreographyStatisticsId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId) {
                    foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceChoreographyStatisticsId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = $collRoutinesRelatedByPerformanceChoreographyStatisticsId;
                $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceChoreographyStatisticsId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceChoreographyStatisticsId(Collection $routinesRelatedByPerformanceChoreographyStatisticsId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceChoreographyStatisticsIdToDelete */
        $routinesRelatedByPerformanceChoreographyStatisticsIdToDelete = $this->getRoutinesRelatedByPerformanceChoreographyStatisticsId(new Criteria(), $con)->diff($routinesRelatedByPerformanceChoreographyStatisticsId);


        $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion = $routinesRelatedByPerformanceChoreographyStatisticsIdToDelete;

        foreach ($routinesRelatedByPerformanceChoreographyStatisticsIdToDelete as $routineRelatedByPerformanceChoreographyStatisticsIdRemoved) {
            $routineRelatedByPerformanceChoreographyStatisticsIdRemoved->setPerformanceStatisticsRelatedByPerformanceChoreographyStatisticsId(null);
        }

        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = null;
        foreach ($routinesRelatedByPerformanceChoreographyStatisticsId as $routineRelatedByPerformanceChoreographyStatisticsId) {
            $this->addRoutineRelatedByPerformanceChoreographyStatisticsId($routineRelatedByPerformanceChoreographyStatisticsId);
        }

        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = $routinesRelatedByPerformanceChoreographyStatisticsId;
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial = false;

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
    public function countRoutinesRelatedByPerformanceChoreographyStatisticsId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceChoreographyStatisticsId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceStatisticsRelatedByPerformanceChoreographyStatisticsId($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceChoreographyStatisticsId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId === null) {
            $this->initRoutinesRelatedByPerformanceChoreographyStatisticsId();
            $this->collRoutinesRelatedByPerformanceChoreographyStatisticsIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceChoreographyStatisticsId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceChoreographyStatisticsId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceChoreographyStatisticsId(ChildRoutine $routineRelatedByPerformanceChoreographyStatisticsId)
    {
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId[]= $routineRelatedByPerformanceChoreographyStatisticsId;
        $routineRelatedByPerformanceChoreographyStatisticsId->setPerformanceStatisticsRelatedByPerformanceChoreographyStatisticsId($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceChoreographyStatisticsId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceChoreographyStatisticsId(ChildRoutine $routineRelatedByPerformanceChoreographyStatisticsId)
    {
        if ($this->getRoutinesRelatedByPerformanceChoreographyStatisticsId()->contains($routineRelatedByPerformanceChoreographyStatisticsId)) {
            $pos = $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->search($routineRelatedByPerformanceChoreographyStatisticsId);
            $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId;
                $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceChoreographyStatisticsIdScheduledForDeletion[]= $routineRelatedByPerformanceChoreographyStatisticsId;
            $routineRelatedByPerformanceChoreographyStatisticsId->setPerformanceStatisticsRelatedByPerformanceChoreographyStatisticsId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistics is new, it will return
     * an empty collection; or if this PerformanceStatistics has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceChoreographyStatisticsId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistics.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceChoreographyStatisticsIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceChoreographyStatisticsId($query, $con);
    }

    /**
     * Clears out the collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoutinesRelatedByPerformanceMusicAndTimingStatisticsId()
     */
    public function clearRoutinesRelatedByPerformanceMusicAndTimingStatisticsId()
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId collection loaded partially.
     */
    public function resetPartialRoutinesRelatedByPerformanceMusicAndTimingStatisticsId($v = true)
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial = $v;
    }

    /**
     * Initializes the collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId collection.
     *
     * By default this just sets the collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId collection to an empty array (like clearcollRoutinesRelatedByPerformanceMusicAndTimingStatisticsId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRoutinesRelatedByPerformanceMusicAndTimingStatisticsId($overrideExisting = true)
    {
        if (null !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId && !$overrideExisting) {
            return;
        }
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = new ObjectCollection();
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->setModel('\iuf\junia\model\Routine');
    }

    /**
     * Gets an array of ChildRoutine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerformanceStatistics is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     * @throws PropelException
     */
    public function getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId) {
                // return empty collection
                $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticsId();
            } else {
                $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = ChildRoutineQuery::create(null, $criteria)
                    ->filterByPerformanceStatisticsRelatedByPerformanceMusicAndTimingStatisticsId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial && count($collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId)) {
                        $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticsId(false);

                        foreach ($collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId as $obj) {
                            if (false == $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->contains($obj)) {
                                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->append($obj);
                            }
                        }

                        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial = true;
                    }

                    return $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId;
                }

                if ($partial && $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId) {
                    foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId as $obj) {
                        if ($obj->isNew()) {
                            $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId[] = $obj;
                        }
                    }
                }

                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = $collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId;
                $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial = false;
            }
        }

        return $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId;
    }

    /**
     * Sets a collection of ChildRoutine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $routinesRelatedByPerformanceMusicAndTimingStatisticsId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function setRoutinesRelatedByPerformanceMusicAndTimingStatisticsId(Collection $routinesRelatedByPerformanceMusicAndTimingStatisticsId, ConnectionInterface $con = null)
    {
        /** @var ChildRoutine[] $routinesRelatedByPerformanceMusicAndTimingStatisticsIdToDelete */
        $routinesRelatedByPerformanceMusicAndTimingStatisticsIdToDelete = $this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId(new Criteria(), $con)->diff($routinesRelatedByPerformanceMusicAndTimingStatisticsId);


        $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion = $routinesRelatedByPerformanceMusicAndTimingStatisticsIdToDelete;

        foreach ($routinesRelatedByPerformanceMusicAndTimingStatisticsIdToDelete as $routineRelatedByPerformanceMusicAndTimingStatisticsIdRemoved) {
            $routineRelatedByPerformanceMusicAndTimingStatisticsIdRemoved->setPerformanceStatisticsRelatedByPerformanceMusicAndTimingStatisticsId(null);
        }

        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = null;
        foreach ($routinesRelatedByPerformanceMusicAndTimingStatisticsId as $routineRelatedByPerformanceMusicAndTimingStatisticsId) {
            $this->addRoutineRelatedByPerformanceMusicAndTimingStatisticsId($routineRelatedByPerformanceMusicAndTimingStatisticsId);
        }

        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = $routinesRelatedByPerformanceMusicAndTimingStatisticsId;
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial = false;

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
    public function countRoutinesRelatedByPerformanceMusicAndTimingStatisticsId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial && !$this->isNew();
        if (null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId());
            }

            $query = ChildRoutineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerformanceStatisticsRelatedByPerformanceMusicAndTimingStatisticsId($this)
                ->count($con);
        }

        return count($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId);
    }

    /**
     * Method called to associate a ChildRoutine object to this object
     * through the ChildRoutine foreign key attribute.
     *
     * @param  ChildRoutine $l ChildRoutine
     * @return $this|\iuf\junia\model\PerformanceStatistics The current object (for fluent API support)
     */
    public function addRoutineRelatedByPerformanceMusicAndTimingStatisticsId(ChildRoutine $l)
    {
        if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId === null) {
            $this->initRoutinesRelatedByPerformanceMusicAndTimingStatisticsId();
            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdPartial = true;
        }

        if (!$this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->contains($l)) {
            $this->doAddRoutineRelatedByPerformanceMusicAndTimingStatisticsId($l);
        }

        return $this;
    }

    /**
     * @param ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticsId The ChildRoutine object to add.
     */
    protected function doAddRoutineRelatedByPerformanceMusicAndTimingStatisticsId(ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticsId)
    {
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId[]= $routineRelatedByPerformanceMusicAndTimingStatisticsId;
        $routineRelatedByPerformanceMusicAndTimingStatisticsId->setPerformanceStatisticsRelatedByPerformanceMusicAndTimingStatisticsId($this);
    }

    /**
     * @param  ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticsId The ChildRoutine object to remove.
     * @return $this|ChildPerformanceStatistics The current object (for fluent API support)
     */
    public function removeRoutineRelatedByPerformanceMusicAndTimingStatisticsId(ChildRoutine $routineRelatedByPerformanceMusicAndTimingStatisticsId)
    {
        if ($this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId()->contains($routineRelatedByPerformanceMusicAndTimingStatisticsId)) {
            $pos = $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->search($routineRelatedByPerformanceMusicAndTimingStatisticsId);
            $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId->remove($pos);
            if (null === $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion) {
                $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion = clone $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId;
                $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion->clear();
            }
            $this->routinesRelatedByPerformanceMusicAndTimingStatisticsIdScheduledForDeletion[]= $routineRelatedByPerformanceMusicAndTimingStatisticsId;
            $routineRelatedByPerformanceMusicAndTimingStatisticsId->setPerformanceStatisticsRelatedByPerformanceMusicAndTimingStatisticsId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PerformanceStatistics is new, it will return
     * an empty collection; or if this PerformanceStatistics has previously
     * been saved, it will retrieve related RoutinesRelatedByPerformanceMusicAndTimingStatisticsId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PerformanceStatistics.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRoutine[] List of ChildRoutine objects
     */
    public function getRoutinesRelatedByPerformanceMusicAndTimingStatisticsIdJoinStartgroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRoutineQuery::create(null, $criteria);
        $query->joinWith('Startgroup', $joinBehavior);

        return $this->getRoutinesRelatedByPerformanceMusicAndTimingStatisticsId($query, $con);
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
            if ($this->collRoutinesRelatedByPerformanceTotalStatisticsId) {
                foreach ($this->collRoutinesRelatedByPerformanceTotalStatisticsId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId) {
                foreach ($this->collRoutinesRelatedByPerformanceExecutionStatisticsId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId) {
                foreach ($this->collRoutinesRelatedByPerformanceChoreographyStatisticsId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId) {
                foreach ($this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRoutinesRelatedByPerformanceTotalStatisticsId = null;
        $this->collRoutinesRelatedByPerformanceExecutionStatisticsId = null;
        $this->collRoutinesRelatedByPerformanceChoreographyStatisticsId = null;
        $this->collRoutinesRelatedByPerformanceMusicAndTimingStatisticsId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PerformanceStatisticsTableMap::DEFAULT_STRING_FORMAT);
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

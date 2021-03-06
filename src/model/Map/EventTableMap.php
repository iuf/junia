<?php

namespace iuf\junia\model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use iuf\junia\model\Event;
use iuf\junia\model\EventQuery;


/**
 * This class defines the structure of the 'kk_junia_event' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EventTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.EventTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'keeko';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'kk_junia_event';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\iuf\\junia\\model\\Event';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Event';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'kk_junia_event.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'kk_junia_event.name';

    /**
     * the column name for the start field
     */
    const COL_START = 'kk_junia_event.start';

    /**
     * the column name for the end field
     */
    const COL_END = 'kk_junia_event.end';

    /**
     * the column name for the performance_total_statistic_id field
     */
    const COL_PERFORMANCE_TOTAL_STATISTIC_ID = 'kk_junia_event.performance_total_statistic_id';

    /**
     * the column name for the performance_execution_statistic_id field
     */
    const COL_PERFORMANCE_EXECUTION_STATISTIC_ID = 'kk_junia_event.performance_execution_statistic_id';

    /**
     * the column name for the performance_choreography_statistic_id field
     */
    const COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID = 'kk_junia_event.performance_choreography_statistic_id';

    /**
     * the column name for the performance_music_and_timing_statistic_id field
     */
    const COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID = 'kk_junia_event.performance_music_and_timing_statistic_id';

    /**
     * the column name for the slug field
     */
    const COL_SLUG = 'kk_junia_event.slug';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Start', 'End', 'PerformanceTotalStatisticId', 'PerformanceExecutionStatisticId', 'PerformanceChoreographyStatisticId', 'PerformanceMusicAndTimingStatisticId', 'Slug', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'start', 'end', 'performanceTotalStatisticId', 'performanceExecutionStatisticId', 'performanceChoreographyStatisticId', 'performanceMusicAndTimingStatisticId', 'slug', ),
        self::TYPE_COLNAME       => array(EventTableMap::COL_ID, EventTableMap::COL_NAME, EventTableMap::COL_START, EventTableMap::COL_END, EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, EventTableMap::COL_SLUG, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'start', 'end', 'performance_total_statistic_id', 'performance_execution_statistic_id', 'performance_choreography_statistic_id', 'performance_music_and_timing_statistic_id', 'slug', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Start' => 2, 'End' => 3, 'PerformanceTotalStatisticId' => 4, 'PerformanceExecutionStatisticId' => 5, 'PerformanceChoreographyStatisticId' => 6, 'PerformanceMusicAndTimingStatisticId' => 7, 'Slug' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'start' => 2, 'end' => 3, 'performanceTotalStatisticId' => 4, 'performanceExecutionStatisticId' => 5, 'performanceChoreographyStatisticId' => 6, 'performanceMusicAndTimingStatisticId' => 7, 'slug' => 8, ),
        self::TYPE_COLNAME       => array(EventTableMap::COL_ID => 0, EventTableMap::COL_NAME => 1, EventTableMap::COL_START => 2, EventTableMap::COL_END => 3, EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID => 4, EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID => 5, EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID => 6, EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID => 7, EventTableMap::COL_SLUG => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'start' => 2, 'end' => 3, 'performance_total_statistic_id' => 4, 'performance_execution_statistic_id' => 5, 'performance_choreography_statistic_id' => 6, 'performance_music_and_timing_statistic_id' => 7, 'slug' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('kk_junia_event');
        $this->setPhpName('Event');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\iuf\\junia\\model\\Event');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->getColumn('name')->setPrimaryString(true);
        $this->addColumn('start', 'Start', 'DATE', false, null, null);
        $this->addColumn('end', 'End', 'DATE', false, null, null);
        $this->addForeignKey('performance_total_statistic_id', 'PerformanceTotalStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_execution_statistic_id', 'PerformanceExecutionStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_choreography_statistic_id', 'PerformanceChoreographyStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_music_and_timing_statistic_id', 'PerformanceMusicAndTimingStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addColumn('slug', 'Slug', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PerformanceTotalStatistic', '\\iuf\\junia\\model\\PerformanceStatistic', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':performance_total_statistic_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('PerformanceExecutionStatistic', '\\iuf\\junia\\model\\PerformanceStatistic', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':performance_execution_statistic_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('PerformanceChoreographyStatistic', '\\iuf\\junia\\model\\PerformanceStatistic', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':performance_choreography_statistic_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('PerformanceMusicAndTimingStatistic', '\\iuf\\junia\\model\\PerformanceStatistic', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':performance_music_and_timing_statistic_id',
    1 => ':id',
  ),
), 'SET NULL', null, null, false);
        $this->addRelation('Startgroup', '\\iuf\\junia\\model\\Startgroup', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'Startgroups', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'sluggable' => array('slug_column' => 'slug', 'slug_pattern' => '', 'replace_pattern' => '/\W+/', 'replacement' => '-', 'separator' => '-', 'permanent' => 'false', 'scope_column' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to kk_junia_event     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StartgroupTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? EventTableMap::CLASS_DEFAULT : EventTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Event object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EventTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EventTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventTableMap::OM_CLASS;
            /** @var Event $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = EventTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EventTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Event $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EventTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(EventTableMap::COL_ID);
            $criteria->addSelectColumn(EventTableMap::COL_NAME);
            $criteria->addSelectColumn(EventTableMap::COL_START);
            $criteria->addSelectColumn(EventTableMap::COL_END);
            $criteria->addSelectColumn(EventTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID);
            $criteria->addSelectColumn(EventTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID);
            $criteria->addSelectColumn(EventTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID);
            $criteria->addSelectColumn(EventTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID);
            $criteria->addSelectColumn(EventTableMap::COL_SLUG);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.start');
            $criteria->addSelectColumn($alias . '.end');
            $criteria->addSelectColumn($alias . '.performance_total_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_execution_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_choreography_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_music_and_timing_statistic_id');
            $criteria->addSelectColumn($alias . '.slug');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(EventTableMap::DATABASE_NAME)->getTable(EventTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EventTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EventTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EventTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Event or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Event object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \iuf\junia\model\Event) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventTableMap::DATABASE_NAME);
            $criteria->add(EventTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EventQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EventTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kk_junia_event table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EventQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Event or Criteria object.
     *
     * @param mixed               $criteria Criteria or Event object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Event object
        }

        if ($criteria->containsKey(EventTableMap::COL_ID) && $criteria->keyContainsValue(EventTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EventTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = EventQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EventTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EventTableMap::buildTableMap();

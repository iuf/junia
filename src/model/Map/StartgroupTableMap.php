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
use iuf\junia\model\Startgroup;
use iuf\junia\model\StartgroupQuery;


/**
 * This class defines the structure of the 'kk_junia_startgroup' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StartgroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.StartgroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'keeko';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'kk_junia_startgroup';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\iuf\\junia\\model\\Startgroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Startgroup';

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
    const COL_ID = 'kk_junia_startgroup.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'kk_junia_startgroup.name';

    /**
     * the column name for the slug field
     */
    const COL_SLUG = 'kk_junia_startgroup.slug';

    /**
     * the column name for the competition_id field
     */
    const COL_COMPETITION_ID = 'kk_junia_startgroup.competition_id';

    /**
     * the column name for the event_id field
     */
    const COL_EVENT_ID = 'kk_junia_startgroup.event_id';

    /**
     * the column name for the performance_total_statistic_id field
     */
    const COL_PERFORMANCE_TOTAL_STATISTIC_ID = 'kk_junia_startgroup.performance_total_statistic_id';

    /**
     * the column name for the performance_execution_statistic_id field
     */
    const COL_PERFORMANCE_EXECUTION_STATISTIC_ID = 'kk_junia_startgroup.performance_execution_statistic_id';

    /**
     * the column name for the performance_choreography_statistic_id field
     */
    const COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID = 'kk_junia_startgroup.performance_choreography_statistic_id';

    /**
     * the column name for the performance_music_and_timing_statistic_id field
     */
    const COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID = 'kk_junia_startgroup.performance_music_and_timing_statistic_id';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Slug', 'CompetitionId', 'EventId', 'PerformanceTotalStatisticId', 'PerformanceExecutionStatisticId', 'PerformanceChoreographyStatisticId', 'PerformanceMusicAndTimingStatisticId', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'slug', 'competitionId', 'eventId', 'performanceTotalStatisticId', 'performanceExecutionStatisticId', 'performanceChoreographyStatisticId', 'performanceMusicAndTimingStatisticId', ),
        self::TYPE_COLNAME       => array(StartgroupTableMap::COL_ID, StartgroupTableMap::COL_NAME, StartgroupTableMap::COL_SLUG, StartgroupTableMap::COL_COMPETITION_ID, StartgroupTableMap::COL_EVENT_ID, StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID, StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID, StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID, StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'slug', 'competition_id', 'event_id', 'performance_total_statistic_id', 'performance_execution_statistic_id', 'performance_choreography_statistic_id', 'performance_music_and_timing_statistic_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Slug' => 2, 'CompetitionId' => 3, 'EventId' => 4, 'PerformanceTotalStatisticId' => 5, 'PerformanceExecutionStatisticId' => 6, 'PerformanceChoreographyStatisticId' => 7, 'PerformanceMusicAndTimingStatisticId' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'slug' => 2, 'competitionId' => 3, 'eventId' => 4, 'performanceTotalStatisticId' => 5, 'performanceExecutionStatisticId' => 6, 'performanceChoreographyStatisticId' => 7, 'performanceMusicAndTimingStatisticId' => 8, ),
        self::TYPE_COLNAME       => array(StartgroupTableMap::COL_ID => 0, StartgroupTableMap::COL_NAME => 1, StartgroupTableMap::COL_SLUG => 2, StartgroupTableMap::COL_COMPETITION_ID => 3, StartgroupTableMap::COL_EVENT_ID => 4, StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID => 5, StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID => 6, StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID => 7, StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'slug' => 2, 'competition_id' => 3, 'event_id' => 4, 'performance_total_statistic_id' => 5, 'performance_execution_statistic_id' => 6, 'performance_choreography_statistic_id' => 7, 'performance_music_and_timing_statistic_id' => 8, ),
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
        $this->setName('kk_junia_startgroup');
        $this->setPhpName('Startgroup');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\iuf\\junia\\model\\Startgroup');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('slug', 'Slug', 'VARCHAR', false, 100, null);
        $this->addForeignKey('competition_id', 'CompetitionId', 'INTEGER', 'kk_junia_competition', 'id', true, 10, null);
        $this->addForeignKey('event_id', 'EventId', 'INTEGER', 'kk_junia_event', 'id', true, 10, null);
        $this->addForeignKey('performance_total_statistic_id', 'PerformanceTotalStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_execution_statistic_id', 'PerformanceExecutionStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_choreography_statistic_id', 'PerformanceChoreographyStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
        $this->addForeignKey('performance_music_and_timing_statistic_id', 'PerformanceMusicAndTimingStatisticId', 'INTEGER', 'kk_junia_performance_statistic', 'id', false, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Competition', '\\iuf\\junia\\model\\Competition', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':competition_id',
    1 => ':id',
  ),
), 'RESTRICT', null, null, false);
        $this->addRelation('Event', '\\iuf\\junia\\model\\Event', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
        $this->addRelation('Routine', '\\iuf\\junia\\model\\Routine', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':startgroup_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'Routines', false);
        $this->addRelation('Judge', '\\iuf\\junia\\model\\Judge', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':startgroup_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'Judges', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to kk_junia_startgroup     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RoutineTableMap::clearInstancePool();
        JudgeTableMap::clearInstancePool();
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
        return $withPrefix ? StartgroupTableMap::CLASS_DEFAULT : StartgroupTableMap::OM_CLASS;
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
     * @return array           (Startgroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StartgroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StartgroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StartgroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StartgroupTableMap::OM_CLASS;
            /** @var Startgroup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StartgroupTableMap::addInstanceToPool($obj, $key);
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
            $key = StartgroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StartgroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Startgroup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StartgroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StartgroupTableMap::COL_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_NAME);
            $criteria->addSelectColumn(StartgroupTableMap::COL_SLUG);
            $criteria->addSelectColumn(StartgroupTableMap::COL_COMPETITION_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_EVENT_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_PERFORMANCE_TOTAL_STATISTIC_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_PERFORMANCE_EXECUTION_STATISTIC_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_PERFORMANCE_CHOREOGRAPHY_STATISTIC_ID);
            $criteria->addSelectColumn(StartgroupTableMap::COL_PERFORMANCE_MUSIC_AND_TIMING_STATISTIC_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.slug');
            $criteria->addSelectColumn($alias . '.competition_id');
            $criteria->addSelectColumn($alias . '.event_id');
            $criteria->addSelectColumn($alias . '.performance_total_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_execution_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_choreography_statistic_id');
            $criteria->addSelectColumn($alias . '.performance_music_and_timing_statistic_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(StartgroupTableMap::DATABASE_NAME)->getTable(StartgroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StartgroupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StartgroupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StartgroupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Startgroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Startgroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \iuf\junia\model\Startgroup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StartgroupTableMap::DATABASE_NAME);
            $criteria->add(StartgroupTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = StartgroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StartgroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StartgroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kk_junia_startgroup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StartgroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Startgroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or Startgroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StartgroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Startgroup object
        }

        if ($criteria->containsKey(StartgroupTableMap::COL_ID) && $criteria->keyContainsValue(StartgroupTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StartgroupTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = StartgroupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StartgroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StartgroupTableMap::buildTableMap();

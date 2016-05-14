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
use iuf\junia\model\PerformanceScore;
use iuf\junia\model\PerformanceScoreQuery;


/**
 * This class defines the structure of the 'kk_junia_performance_score' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PerformanceScoreTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PerformanceScoreTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'keeko';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'kk_junia_performance_score';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\iuf\\junia\\model\\PerformanceScore';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PerformanceScore';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the execution field
     */
    const COL_EXECUTION = 'kk_junia_performance_score.execution';

    /**
     * the column name for the choreography field
     */
    const COL_CHOREOGRAPHY = 'kk_junia_performance_score.choreography';

    /**
     * the column name for the music_and_timing field
     */
    const COL_MUSIC_AND_TIMING = 'kk_junia_performance_score.music_and_timing';

    /**
     * the column name for the id field
     */
    const COL_ID = 'kk_junia_performance_score.id';

    /**
     * the column name for the routine_id field
     */
    const COL_ROUTINE_ID = 'kk_junia_performance_score.routine_id';

    /**
     * the column name for the judge_id field
     */
    const COL_JUDGE_ID = 'kk_junia_performance_score.judge_id';

    /**
     * the column name for the total field
     */
    const COL_TOTAL = 'kk_junia_performance_score.total';

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
        self::TYPE_PHPNAME       => array('Execution', 'Choreography', 'MusicAndTiming', 'Id', 'RoutineId', 'JudgeId', 'Total', ),
        self::TYPE_CAMELNAME     => array('execution', 'choreography', 'musicAndTiming', 'id', 'routineId', 'judgeId', 'total', ),
        self::TYPE_COLNAME       => array(PerformanceScoreTableMap::COL_EXECUTION, PerformanceScoreTableMap::COL_CHOREOGRAPHY, PerformanceScoreTableMap::COL_MUSIC_AND_TIMING, PerformanceScoreTableMap::COL_ID, PerformanceScoreTableMap::COL_ROUTINE_ID, PerformanceScoreTableMap::COL_JUDGE_ID, PerformanceScoreTableMap::COL_TOTAL, ),
        self::TYPE_FIELDNAME     => array('execution', 'choreography', 'music_and_timing', 'id', 'routine_id', 'judge_id', 'total', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Execution' => 0, 'Choreography' => 1, 'MusicAndTiming' => 2, 'Id' => 3, 'RoutineId' => 4, 'JudgeId' => 5, 'Total' => 6, ),
        self::TYPE_CAMELNAME     => array('execution' => 0, 'choreography' => 1, 'musicAndTiming' => 2, 'id' => 3, 'routineId' => 4, 'judgeId' => 5, 'total' => 6, ),
        self::TYPE_COLNAME       => array(PerformanceScoreTableMap::COL_EXECUTION => 0, PerformanceScoreTableMap::COL_CHOREOGRAPHY => 1, PerformanceScoreTableMap::COL_MUSIC_AND_TIMING => 2, PerformanceScoreTableMap::COL_ID => 3, PerformanceScoreTableMap::COL_ROUTINE_ID => 4, PerformanceScoreTableMap::COL_JUDGE_ID => 5, PerformanceScoreTableMap::COL_TOTAL => 6, ),
        self::TYPE_FIELDNAME     => array('execution' => 0, 'choreography' => 1, 'music_and_timing' => 2, 'id' => 3, 'routine_id' => 4, 'judge_id' => 5, 'total' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('kk_junia_performance_score');
        $this->setPhpName('PerformanceScore');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\iuf\\junia\\model\\PerformanceScore');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('execution', 'Execution', 'FLOAT', false, 10, null);
        $this->addColumn('choreography', 'Choreography', 'FLOAT', false, 10, null);
        $this->addColumn('music_and_timing', 'MusicAndTiming', 'FLOAT', false, 10, null);
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , 'kk_junia_score', 'id', true, null, null);
        $this->addForeignKey('routine_id', 'RoutineId', 'INTEGER', 'kk_junia_routine', 'id', false, 10, null);
        $this->addForeignKey('judge_id', 'JudgeId', 'INTEGER', 'kk_junia_judge', 'id', false, 10, null);
        $this->addColumn('total', 'Total', 'FLOAT', false, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Score', '\\iuf\\junia\\model\\Score', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Routine', '\\iuf\\junia\\model\\Routine', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':routine_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Judge', '\\iuf\\junia\\model\\Judge', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':judge_id',
    1 => ':id',
  ),
), null, null, null, false);
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
            'concrete_inheritance' => array('extends' => 'score', 'descendant_column' => 'descendant_class', 'copy_data_to_parent' => 'true', 'copy_data_to_child' => 'false', 'schema' => '', 'exclude_behaviors' => '', ),
        );
    } // getBehaviors()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
                ? 3 + $offset
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
        return $withPrefix ? PerformanceScoreTableMap::CLASS_DEFAULT : PerformanceScoreTableMap::OM_CLASS;
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
     * @return array           (PerformanceScore object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PerformanceScoreTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PerformanceScoreTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PerformanceScoreTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PerformanceScoreTableMap::OM_CLASS;
            /** @var PerformanceScore $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PerformanceScoreTableMap::addInstanceToPool($obj, $key);
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
            $key = PerformanceScoreTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PerformanceScoreTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PerformanceScore $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PerformanceScoreTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_EXECUTION);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_CHOREOGRAPHY);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_MUSIC_AND_TIMING);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_ID);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_ROUTINE_ID);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_JUDGE_ID);
            $criteria->addSelectColumn(PerformanceScoreTableMap::COL_TOTAL);
        } else {
            $criteria->addSelectColumn($alias . '.execution');
            $criteria->addSelectColumn($alias . '.choreography');
            $criteria->addSelectColumn($alias . '.music_and_timing');
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.routine_id');
            $criteria->addSelectColumn($alias . '.judge_id');
            $criteria->addSelectColumn($alias . '.total');
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
        return Propel::getServiceContainer()->getDatabaseMap(PerformanceScoreTableMap::DATABASE_NAME)->getTable(PerformanceScoreTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PerformanceScoreTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PerformanceScoreTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PerformanceScoreTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PerformanceScore or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PerformanceScore object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceScoreTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \iuf\junia\model\PerformanceScore) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PerformanceScoreTableMap::DATABASE_NAME);
            $criteria->add(PerformanceScoreTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PerformanceScoreQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PerformanceScoreTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PerformanceScoreTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kk_junia_performance_score table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PerformanceScoreQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PerformanceScore or Criteria object.
     *
     * @param mixed               $criteria Criteria or PerformanceScore object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PerformanceScoreTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PerformanceScore object
        }


        // Set the correct dbName
        $query = PerformanceScoreQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PerformanceScoreTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PerformanceScoreTableMap::buildTableMap();

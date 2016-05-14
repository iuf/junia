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
use iuf\junia\model\Score;
use iuf\junia\model\ScoreQuery;


/**
 * This class defines the structure of the 'kk_junia_score' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ScoreTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ScoreTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'keeko';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'kk_junia_score';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\iuf\\junia\\model\\Score';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Score';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'kk_junia_score.id';

    /**
     * the column name for the routine_id field
     */
    const COL_ROUTINE_ID = 'kk_junia_score.routine_id';

    /**
     * the column name for the judge_id field
     */
    const COL_JUDGE_ID = 'kk_junia_score.judge_id';

    /**
     * the column name for the total field
     */
    const COL_TOTAL = 'kk_junia_score.total';

    /**
     * the column name for the descendant_class field
     */
    const COL_DESCENDANT_CLASS = 'kk_junia_score.descendant_class';

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
        self::TYPE_PHPNAME       => array('Id', 'RoutineId', 'JudgeId', 'Total', 'DescendantClass', ),
        self::TYPE_CAMELNAME     => array('id', 'routineId', 'judgeId', 'total', 'descendantClass', ),
        self::TYPE_COLNAME       => array(ScoreTableMap::COL_ID, ScoreTableMap::COL_ROUTINE_ID, ScoreTableMap::COL_JUDGE_ID, ScoreTableMap::COL_TOTAL, ScoreTableMap::COL_DESCENDANT_CLASS, ),
        self::TYPE_FIELDNAME     => array('id', 'routine_id', 'judge_id', 'total', 'descendant_class', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'RoutineId' => 1, 'JudgeId' => 2, 'Total' => 3, 'DescendantClass' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'routineId' => 1, 'judgeId' => 2, 'total' => 3, 'descendantClass' => 4, ),
        self::TYPE_COLNAME       => array(ScoreTableMap::COL_ID => 0, ScoreTableMap::COL_ROUTINE_ID => 1, ScoreTableMap::COL_JUDGE_ID => 2, ScoreTableMap::COL_TOTAL => 3, ScoreTableMap::COL_DESCENDANT_CLASS => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'routine_id' => 1, 'judge_id' => 2, 'total' => 3, 'descendant_class' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('kk_junia_score');
        $this->setPhpName('Score');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\iuf\\junia\\model\\Score');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('routine_id', 'RoutineId', 'INTEGER', 'kk_junia_routine', 'id', false, 10, null);
        $this->addForeignKey('judge_id', 'JudgeId', 'INTEGER', 'kk_junia_judge', 'id', false, 10, null);
        $this->addColumn('total', 'Total', 'FLOAT', false, 10, null);
        $this->addColumn('descendant_class', 'DescendantClass', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        $this->addRelation('PerformanceScore', '\\iuf\\junia\\model\\PerformanceScore', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
            'concrete_inheritance_parent' => array('descendant_column' => 'descendant_class', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to kk_junia_score     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PerformanceScoreTableMap::clearInstancePool();
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
        return $withPrefix ? ScoreTableMap::CLASS_DEFAULT : ScoreTableMap::OM_CLASS;
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
     * @return array           (Score object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ScoreTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ScoreTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ScoreTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ScoreTableMap::OM_CLASS;
            /** @var Score $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ScoreTableMap::addInstanceToPool($obj, $key);
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
            $key = ScoreTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ScoreTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Score $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ScoreTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ScoreTableMap::COL_ID);
            $criteria->addSelectColumn(ScoreTableMap::COL_ROUTINE_ID);
            $criteria->addSelectColumn(ScoreTableMap::COL_JUDGE_ID);
            $criteria->addSelectColumn(ScoreTableMap::COL_TOTAL);
            $criteria->addSelectColumn(ScoreTableMap::COL_DESCENDANT_CLASS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.routine_id');
            $criteria->addSelectColumn($alias . '.judge_id');
            $criteria->addSelectColumn($alias . '.total');
            $criteria->addSelectColumn($alias . '.descendant_class');
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
        return Propel::getServiceContainer()->getDatabaseMap(ScoreTableMap::DATABASE_NAME)->getTable(ScoreTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ScoreTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ScoreTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ScoreTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Score or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Score object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \iuf\junia\model\Score) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ScoreTableMap::DATABASE_NAME);
            $criteria->add(ScoreTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ScoreQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ScoreTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ScoreTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kk_junia_score table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ScoreQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Score or Criteria object.
     *
     * @param mixed               $criteria Criteria or Score object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScoreTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Score object
        }

        if ($criteria->containsKey(ScoreTableMap::COL_ID) && $criteria->keyContainsValue(ScoreTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ScoreTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ScoreQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ScoreTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ScoreTableMap::buildTableMap();

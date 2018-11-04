<?php

namespace OrderStatusHistory\Model\Base;

use \Exception;
use \PDO;
use OrderStatusHistory\Model\OrderStatusChange as ChildOrderStatusChange;
use OrderStatusHistory\Model\OrderStatusChangeQuery as ChildOrderStatusChangeQuery;
use OrderStatusHistory\Model\Map\OrderStatusChangeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Order;
use Thelia\Model\OrderStatus;

/**
 * Base class that represents a query for the 'order_status_change' table.
 *
 *
 *
 * @method     ChildOrderStatusChangeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildOrderStatusChangeQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildOrderStatusChangeQuery orderByOrderStatusId($order = Criteria::ASC) Order by the order_status_id column
 * @method     ChildOrderStatusChangeQuery orderByChangeDate($order = Criteria::ASC) Order by the change_date column
 *
 * @method     ChildOrderStatusChangeQuery groupById() Group by the id column
 * @method     ChildOrderStatusChangeQuery groupByOrderId() Group by the order_id column
 * @method     ChildOrderStatusChangeQuery groupByOrderStatusId() Group by the order_status_id column
 * @method     ChildOrderStatusChangeQuery groupByChangeDate() Group by the change_date column
 *
 * @method     ChildOrderStatusChangeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOrderStatusChangeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOrderStatusChangeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOrderStatusChangeQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildOrderStatusChangeQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildOrderStatusChangeQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildOrderStatusChangeQuery leftJoinOrderStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderStatus relation
 * @method     ChildOrderStatusChangeQuery rightJoinOrderStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderStatus relation
 * @method     ChildOrderStatusChangeQuery innerJoinOrderStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderStatus relation
 *
 * @method     ChildOrderStatusChange findOne(ConnectionInterface $con = null) Return the first ChildOrderStatusChange matching the query
 * @method     ChildOrderStatusChange findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOrderStatusChange matching the query, or a new ChildOrderStatusChange object populated from the query conditions when no match is found
 *
 * @method     ChildOrderStatusChange findOneById(int $id) Return the first ChildOrderStatusChange filtered by the id column
 * @method     ChildOrderStatusChange findOneByOrderId(int $order_id) Return the first ChildOrderStatusChange filtered by the order_id column
 * @method     ChildOrderStatusChange findOneByOrderStatusId(int $order_status_id) Return the first ChildOrderStatusChange filtered by the order_status_id column
 * @method     ChildOrderStatusChange findOneByChangeDate(string $change_date) Return the first ChildOrderStatusChange filtered by the change_date column
 *
 * @method     array findById(int $id) Return ChildOrderStatusChange objects filtered by the id column
 * @method     array findByOrderId(int $order_id) Return ChildOrderStatusChange objects filtered by the order_id column
 * @method     array findByOrderStatusId(int $order_status_id) Return ChildOrderStatusChange objects filtered by the order_status_id column
 * @method     array findByChangeDate(string $change_date) Return ChildOrderStatusChange objects filtered by the change_date column
 *
 */
abstract class OrderStatusChangeQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \OrderStatusHistory\Model\Base\OrderStatusChangeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\OrderStatusHistory\\Model\\OrderStatusChange', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOrderStatusChangeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOrderStatusChangeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \OrderStatusHistory\Model\OrderStatusChangeQuery) {
            return $criteria;
        }
        $query = new \OrderStatusHistory\Model\OrderStatusChangeQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildOrderStatusChange|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrderStatusChangeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OrderStatusChangeTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildOrderStatusChange A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ORDER_ID, ORDER_STATUS_ID, CHANGE_DATE FROM order_status_change WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildOrderStatusChange();
            $obj->hydrate($row);
            OrderStatusChangeTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildOrderStatusChange|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrderStatusChangeTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrderStatusChangeTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderStatusChangeTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the order_status_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderStatusId(1234); // WHERE order_status_id = 1234
     * $query->filterByOrderStatusId(array(12, 34)); // WHERE order_status_id IN (12, 34)
     * $query->filterByOrderStatusId(array('min' => 12)); // WHERE order_status_id > 12
     * </code>
     *
     * @see       filterByOrderStatus()
     *
     * @param     mixed $orderStatusId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByOrderStatusId($orderStatusId = null, $comparison = null)
    {
        if (is_array($orderStatusId)) {
            $useMinMax = false;
            if (isset($orderStatusId['min'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_STATUS_ID, $orderStatusId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderStatusId['max'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_STATUS_ID, $orderStatusId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderStatusChangeTableMap::ORDER_STATUS_ID, $orderStatusId, $comparison);
    }

    /**
     * Filter the query on the change_date column
     *
     * Example usage:
     * <code>
     * $query->filterByChangeDate('2011-03-14'); // WHERE change_date = '2011-03-14'
     * $query->filterByChangeDate('now'); // WHERE change_date = '2011-03-14'
     * $query->filterByChangeDate(array('max' => 'yesterday')); // WHERE change_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $changeDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByChangeDate($changeDate = null, $comparison = null)
    {
        if (is_array($changeDate)) {
            $useMinMax = false;
            if (isset($changeDate['min'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::CHANGE_DATE, $changeDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($changeDate['max'])) {
                $this->addUsingAlias(OrderStatusChangeTableMap::CHANGE_DATE, $changeDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrderStatusChangeTableMap::CHANGE_DATE, $changeDate, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Order object
     *
     * @param \Thelia\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Thelia\Model\Order) {
            return $this
                ->addUsingAlias(OrderStatusChangeTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderStatusChangeTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \Thelia\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\Thelia\Model\OrderQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\OrderStatus object
     *
     * @param \Thelia\Model\OrderStatus|ObjectCollection $orderStatus The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function filterByOrderStatus($orderStatus, $comparison = null)
    {
        if ($orderStatus instanceof \Thelia\Model\OrderStatus) {
            return $this
                ->addUsingAlias(OrderStatusChangeTableMap::ORDER_STATUS_ID, $orderStatus->getId(), $comparison);
        } elseif ($orderStatus instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrderStatusChangeTableMap::ORDER_STATUS_ID, $orderStatus->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrderStatus() only accepts arguments of type \Thelia\Model\OrderStatus or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderStatus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function joinOrderStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderStatus');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OrderStatus');
        }

        return $this;
    }

    /**
     * Use the OrderStatus relation OrderStatus object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderStatusQuery A secondary query class using the current class as primary query
     */
    public function useOrderStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderStatus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderStatus', '\Thelia\Model\OrderStatusQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOrderStatusChange $orderStatusChange Object to remove from the list of results
     *
     * @return ChildOrderStatusChangeQuery The current query, for fluid interface
     */
    public function prune($orderStatusChange = null)
    {
        if ($orderStatusChange) {
            $this->addUsingAlias(OrderStatusChangeTableMap::ID, $orderStatusChange->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the order_status_change table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderStatusChangeTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OrderStatusChangeTableMap::clearInstancePool();
            OrderStatusChangeTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildOrderStatusChange or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildOrderStatusChange object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OrderStatusChangeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OrderStatusChangeTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        OrderStatusChangeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OrderStatusChangeTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // OrderStatusChangeQuery

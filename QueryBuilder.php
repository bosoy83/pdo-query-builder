<?php
/**
 * @author  : Ugurkan Kaya
 * @date    : 24.04.2017
 * @updated : 24.04.2017
 * @PHP PDO MySQL Database Wrapper.
 */

use Queries\JoinQueries\InnerJoin;
use Queries\JoinQueries\RightJoin;
use Queries\JoinQueries\LeftJoin;
use Queries\GroupQuery;
use Queries\LimitQuery;
use Queries\OrderQuery;
use Queries\WhereQuery;

class QueryBuilder
{
    /**
     * @var $_config
     */
    protected $_config = [];
    /**
     * @var $_connection
     */
    protected $_connection;
    /**
     * @var $_table
     */
    protected $_table;
    /**
     * @var $_queries
     */
    protected $_queries = [];
    /**
     * @var $_limit
     */
    protected $_limit;
    /**
     * @var $_options
     */
    protected $_options;
    /**
     * @var $_orderKey
     */
    protected $_orderOptions;
    /**
     * @var $_groupKey
     */
    protected $_groupOptions;
    /**
     * @var $_innerJoins
     */
    protected $_innerJoins = [];
    /**
     * @var $_rightJoins
     */
    protected $_rightJoins = [];
    /**
     * @var $_leftJoins
     */
    protected $_leftJoins = [];
    /**
     * @var $_wheres
     */
    protected $_wheres = [];

    /**
     * Build the __construct()
     * @param array $_config
     */
    public function __construct(array $_config)
    {
        $this->_config = $_config;

        try {
            $this->_connection = new PDO("mysql:host=" . $this->_config["host"] . ";dbname=" . $this->_config["database"] . ";charset=" . $this->_config["charset"],
                $this->_config["username"],
                $this->_config["password"],
                [
                    PDO::ATTR_EMULATE_PREPARES => true,
                    PDO::ATTR_PERSISTENT       => true
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Set the fetch table.
     * @param $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->_table = $table;

        return $this;
    }

    /**
     * Set the queries.
     * @param $query
     */
    public function setQuery($query)
    {
        $this->_queries[] = $query;
    }

    /**
     * Set the fetch limit.
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->_limit = (int)$limit;

        return $this;
    }

    /**
     * Set the fetch options.
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->_options = $options;

        return $this;
    }

    /**
     * Set the fetch order options.
     * @param $orderKey
     * @param $orderType
     * @return $this
     */
    public function setOrder($orderKey, $orderType = "ASC")
    {
        $this->_orderOptions = [
            "orderKey"  => $orderKey,
            "orderType" => $orderType
        ];

        return $this;
    }

    /**
     * Set the fetch group options.
     * @param $groupKey
     * @return $this
     */
    public function setGroup($groupKey)
    {
        $this->_groupOptions = $groupKey;

        return $this;
    }

    /**
     * Set the inner joins.
     * @param $table
     * @param $joinAs
     * @param $joinColumn
     * @param $tableColumn
     * @return $this
     */
    public function setInnerJoins($table, $joinAs, $joinColumn, $tableColumn)
    {
        $this->_innerJoins[] = [
            "table"       => $table,
            "joinAs"      => $joinAs,
            "joinColumn"  => $joinColumn,
            "tableColumn" => $tableColumn
        ];

        return $this;
    }

    /**
     * Set the right joins.
     * @param $table
     * @param $joinAs
     * @param $joinColumn
     * @param $tableColumn
     * @param $joinOuter
     * @return $this
     */
    public function setRightJoins($table, $joinAs, $joinColumn, $tableColumn, $joinOuter = false)
    {
        $this->_rightJoins[] = [
            "table"       => $table,
            "joinAs"      => $joinAs,
            "joinColumn"  => $joinColumn,
            "tableColumn" => $tableColumn,
            "joinOuter"   => $joinOuter
        ];

        return $this;
    }

    /**
     * Set the left joins.
     * @param $table
     * @param $joinAs
     * @param $joinColumn
     * @param $tableColumn
     * @param $joinOuter
     * @return $this
     */
    public function setLeftJoins($table, $joinAs, $joinColumn, $tableColumn, $joinOuter = false)
    {
        $this->_leftJoins[] = [
            "table"       => $table,
            "joinAs"      => $joinAs,
            "joinColumn"  => $joinColumn,
            "tableColumn" => $tableColumn,
            "joinOuter"   => $joinOuter
        ];

        return $this;
    }

    /**
     * Set the where conditions.
     * @param $whereKey
     * @param $whereOperator
     * @param $whereValue
     * @return $this
     */
    public function setWhere($whereKey, $whereOperator, $whereValue)
    {
        $this->_wheres[] = [
            "whereKey"      => $whereKey,
            "whereOperator" => $whereOperator,
            "whereValue"    => $whereValue
        ];

        return $this;
    }

    /**
     * Get the prepared results.
     * @param bool $fetchOne
     * @return array|bool|mixed|PDOStatement
     */
    public function getResults($fetchOne = false)
    {
        if (!$this->_table) {
            return false;
        }

        if (!$this->_options) {
            $this->_options = "*";
        }

        $this->setQuery("SELECT " . $this->_options . " FROM " . $this->_table);

        if ($this->_innerJoins) {
            foreach ($this->_innerJoins as $join) {
                $this->setQuery(
                    (new InnerJoin($join["table"], $join["joinAs"], $join["joinColumn"], $join["tableColumn"]))
                        ->buildQuery()
                );
            }
        }

        if ($this->_rightJoins) {
            foreach ($this->_rightJoins as $join) {
                $this->setQuery(
                    (new RightJoin($join["table"], $join["joinAs"], $join["joinColumn"], $join["tableColumn"], $join["joinOuter"]))
                        ->buildQuery()
                );
            }
        }

        if ($this->_leftJoins) {
            foreach ($this->_leftJoins as $join) {
                $this->setQuery(
                    (new LeftJoin($join["table"], $join["joinAs"], $join["joinColumn"], $join["tableColumn"], $join["joinOuter"]))
                        ->buildQuery()
                );
            }
        }

        if ($this->_wheres) {
            $this->setQuery("WHERE");
            $mapWheres = [];
            foreach ($this->_wheres as $where) {
                $mapWheres[] = (new WhereQuery($where["whereKey"], $where["whereOperator"]))
                    ->buildQuery();
            }
            $joinWheres = implode(" AND ", $mapWheres);
            $this->setQuery($joinWheres);
        }

        if ($this->_groupOptions) {
            $this->setQuery(
                (new GroupQuery($this->_groupOptions))
                    ->buildQuery());
        }

        if ($this->_orderOptions["orderKey"] && $this->_orderOptions["orderType"]) {
            $this->setQuery(
                (new OrderQuery($this->_orderOptions["orderKey"], $this->_orderOptions["orderType"]))
                    ->buildQuery()
            );
        }

        if ($this->_limit) {
            $this->setQuery(
                (new LimitQuery($this->_limit))
                    ->buildQuery()
            );
        }

        $queries = implode(" ", $this->_queries);

        $getResults = $this->_connection->prepare($queries);

        if ($this->_wheres) {
            foreach ($this->_wheres as $where) {
                $getResults->bindValue(":" . $where["whereKey"], $where["whereValue"]);
            }
        }

        $getResults->execute();

        $getResults = !$fetchOne ? $getResults->fetchAll() : $getResults->fetch();

        if (!$getResults) {
            return false;
        }

        return $getResults;
    }

    /**
     * Save the values.
     * @param array $values
     * @return bool
     */
    public function save(array $values)
    {
        if (!$values) {
            return false;
        }

        $this->setQuery("INSERT INTO `" . $this->_table . "`");

        $insertKeys = array_keys($values);

        $insertKeys = array_map(function ($key) {
            return "`" . $key . "`";
        },
            $insertKeys
        );

        $insertValues = array_keys($values);

        $insertValues = array_map(function ($key) {
            return ":" . $key;
        },
            $insertValues
        );

        $this->setQuery("(" . implode(", ", $insertKeys) . ")");

        $this->setQuery("VALUES(" . implode(", ", $insertValues) . ");");

        $queries = implode(" ", $this->_queries);

        $saveValues = $this->_connection->prepare($queries);

        foreach ($values as $key => $value) {
            $saveValues->bindValue($key, $value);
        }

        if (!$saveValues->execute()) {
            return false;
        }

        return true;
    }
}

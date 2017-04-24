<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries\JoinQueries;

use Queries\QueryInterface;

class LeftJoin implements QueryInterface
{
    /**
     * @var $_table
     */
    protected $_table;
    /**
     * @var $_joinAs
     */
    protected $_joinAs;
    /**
     * @var $_joinColumn
     */
    protected $_joinColumn;
    /**
     * @var $_tableColumn
     */
    protected $_tableColumn;
    /**
     * @var $_joinOuter
     */
    protected $_joinOuter;

    /**
     * Build the __construct()
     * @param $table
     * @param $joinAs
     * @param $joinColumn
     * @param $tableColumn
     * @param $joinOuter
     */
    public function __construct($table, $joinAs, $joinColumn, $tableColumn, $joinOuter = false)
    {
        $this->_table = $table;
        $this->_joinAs = $joinAs;
        $this->_joinColumn = $joinColumn;
        $this->_tableColumn = $tableColumn;
        $this->_joinOuter = $joinOuter;
    }

    /**
     * Build the query.
     * @return bool|string
     */
    public function buildQuery()
    {
        if (!$this->_table) {
            return false;
        }

        if (!$this->_joinAs) {
            return false;
        }

        if (!$this->_joinColumn) {
            return false;
        }

        if (!$this->_tableColumn) {
            return false;
        }

        return "LEFT " . ($this->_joinOuter ? "OUTER " : null) . "JOIN " . $this->_table . " AS " . $this->_joinAs . " ON (" . $this->_tableColumn . " = " . $this->_joinColumn . ")";
    }
}
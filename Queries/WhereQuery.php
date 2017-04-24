<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries;

class WhereQuery implements QueryInterface
{
    /**
     * @var $_whereKey
     */
    protected $_whereKey;
    /**
     * @var $_whereOperator
     */
    protected $_whereOperator;

    /**
     * Build the __construct()
     * @param $whereKey
     * @param $whereOperator
     */
    public function __construct($whereKey, $whereOperator)
    {
        $this->_whereKey = $whereKey;
        $this->_whereOperator = $whereOperator;
    }

    /**
     * Build the query.
     * @return bool|string
     */
    public function buildQuery()
    {
        if (!$this->_whereKey) {
            return false;
        }

        if (!$this->_whereOperator) {
            return false;
        }

        return $this->_whereKey . " " . $this->_whereOperator . " :" . $this->_whereKey;
    }
}
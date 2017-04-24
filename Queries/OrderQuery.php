<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries;

class OrderQuery implements QueryInterface
{
    /**
     * @var $_orderKey
     */
    protected $_orderKey;
    /**
     * @var $_orderType
     */
    protected $_orderType;

    /**
     * Build the __construct()
     * @param $orderKey
     * @param $orderType
     */
    public function __construct($orderKey, $orderType)
    {
        $this->_orderKey = $orderKey;
        $this->_orderType = $orderType;
    }

    /**
     * Build the query.
     * @return bool|string
     */
    public function buildQuery()
    {
        if (!$this->_orderKey) {
            return false;
        }

        if (!$this->_orderType) {
            return false;
        }

        return "ORDER BY " . $this->_orderKey . " " . $this->_orderType;
    }
}
<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries;

class LimitQuery implements QueryInterface
{
    /**
     * @var $_limit
     */
    protected $_limit;

    /**
     * Build the __construct()
     * @param $limit
     */
    public function __construct($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * Build the query.
     * @return bool|string
     */
    public function buildQuery()
    {
        if (!$this->_limit) {
            return false;
        }

        return "LIMIT " . $this->_limit;
    }
}
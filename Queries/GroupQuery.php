<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries;

class GroupQuery implements QueryInterface
{
    /**
     * @var $_groupKey
     */
    protected $_groupKey;

    /**
     * Build the __construct()
     * @param $groupKey
     */
    public function __construct($groupKey)
    {
        $this->_groupKey = $groupKey;
    }

    /**
     * Build the query.
     * @return bool|string
     */
    public function buildQuery()
    {
        if (!$this->_groupKey) {
            return false;
        }

        return "GROUP BY " . $this->_groupKey;
    }
}

<?php
/**
 * @author : Ugurkan Kaya
 * @date   : 24.04.2017
 */

namespace Queries;

interface QueryInterface
{
    /**
     * Build the query.
     */
    public function buildQuery();
}
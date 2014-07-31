<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection;

use JohnKrovitch\ORMBundle\DataSource\Query;

interface Driver
{
    /**
     * Connect source
     *
     * @return mixed
     */
    public function connect();

    /**
     * Read data from source
     *
     * @param Query $query
     * @return mixed
     */
    public function query(Query $query);

    /**
     * Set driver source
     *
     * @param $source
     * @return mixed
     */
    public function setSource($source);

    /**
     * Return driver source type
     *
     * @return mixed
     */
    public function getType();
}
<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

use JohnKrovitch\ORMBundle\Database\Query;

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
    public function read(Query $query);

    /**
     * Write data into source
     *
     * @return mixed
     */
    public function write();

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
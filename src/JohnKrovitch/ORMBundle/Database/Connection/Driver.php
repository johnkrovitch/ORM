<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

interface Driver
{
    /**
     * Read data from source
     *
     * @return mixed
     */
    public function read();

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
}
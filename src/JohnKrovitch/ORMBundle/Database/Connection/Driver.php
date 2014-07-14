<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

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

    /**
     * Return driver source type
     *
     * @return mixed
     */
    public function getType();
}
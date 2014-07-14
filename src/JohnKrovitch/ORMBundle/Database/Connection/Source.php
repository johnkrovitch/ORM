<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

/**
 * Interface Source
 * @package JohnKrovitch\ORMBundle\Database\Connection
 *
 * A source is a container of parameters used by the driver when it try to access to database
 */
interface Source
{
    public function getHost();

    public function getPort();

    public function getName();

    public function getLogin();

    public function getPassword();

    public function getType();
}
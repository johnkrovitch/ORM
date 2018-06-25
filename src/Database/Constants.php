<?php

namespace App\Database;

class Constants
{
    const DATABASE_TYPE_YML = 'yml';

    const DRIVER_TYPE_PDO_MYSQL = 'pdo_mysql';
    const DRIVER_TYPE_YML = 'yml';

    const TYPE_FILE = 'SOURCE_TYPE_FILE';
    const TYPE_DATABASE = 'SOURCE_TYPE_DATABASE';

    // fetching type
    const FETCH_TYPE_OBJECT = 'object';
    const FETCH_TYPE_ARRAY = 'array';

    // query types
    const QUERY_TYPE_SHOW = 'show';
    const QUERY_TYPE_USE = 'use';
    const QUERY_TYPE_CREATE = 'create';
    const QUERY_TYPE_SELECT = 'select';
    const QUERY_TYPE_UPDATE = 'update';
    const QUERY_TYPE_DELETE = 'delete';
    const QUERY_TYPE_DESCRIBE = 'describe';
}

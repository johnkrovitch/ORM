<?php

namespace JohnKrovitch\ORMBundle\Database;

class Constants
{
    const DATABASE_TYPE_YML = 'yml';
    const DRIVER_TYPE_PDO_MYSQL = 'pdo_mysql';

    const TYPE_FILE = 'SOURCE_TYPE_FILE';
    const TYPE_DATABASE = 'SOURCE_TYPE_DATABASE';

    const COLUMN_TYPE_STRING = 'string';
    const COLUMN_TYPE_INTEGER = 'integer';
    const COLUMN_TYPE_TEXT = 'text';
    const COLUMN_TYPE_ID = 'id';

    public static function getColumnsAllowedTypes()
    {
        return [
            self::COLUMN_TYPE_STRING,
            self::COLUMN_TYPE_INTEGER,
            self::COLUMN_TYPE_TEXT,
            self::COLUMN_TYPE_ID,
        ];
    }
}
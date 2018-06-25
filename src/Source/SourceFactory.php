<?php

namespace App\Source;

use App\Database\Connection\Database;

class SourceFactory
{
    public function create(string $name, string $type, string $dsn)
    {
        return new Database($name, $type, $dsn);
    }
}

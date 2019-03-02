<?php

namespace App\Database\Schema;

class ColumnDifferential
{
    private $type;

    public function setType($type)
    {
        $this->type = $type;
    }
}

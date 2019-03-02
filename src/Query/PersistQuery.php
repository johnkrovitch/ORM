<?php

namespace App\Query;

class PersistQuery
{
    const QUERY_TYPE_CREATE = 'create';
    const QUERY_TYPE_UPDATE = 'update';

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}

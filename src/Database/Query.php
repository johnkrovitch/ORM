<?php

namespace App\Database;

class Query
{
    const QUERY_TYPE_SHOW = 'show';
    const QUERY_TYPE_USE = 'use';
    const QUERY_TYPE_CREATE = 'create';
    const QUERY_TYPE_SELECT = 'select';
    const QUERY_TYPE_UPDATE = 'update';
    const QUERY_TYPE_DELETE = 'delete';
    const QUERY_TYPE_DESCRIBE = 'describe';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $parameters = [];

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

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
} 

<?php

namespace App\Database\Schema;

use App\Collection\TypedCollection;

class Column
{
    const COLUMN_TYPE_INTEGER = 'integer';
    const COLUMN_TYPE_FLOAT = 'float';
    const COLUMN_TYPE_STRING = 'string';
    const COLUMN_TYPE_TEXT = 'text';
    const COLUMN_TYPE_DATETIME = 'datetime';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var TypedCollection
     */
    private $behaviors = [];

    /**
     * Column constructor.
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     * @param array  $behaviors
     */
    public function __construct(string $name, string $type, array $options = [], array $behaviors = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
        $this->behaviors = $behaviors;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return TypedCollection
     */
    public function getBehaviors(): TypedCollection
    {
        return $this->behaviors;
    }

    public function isUnique(): bool
    {
        return $this->options['unique'];
    }

    public function isPrimaryKey(): bool
    {
        return $this->options['primary_key'];
    }

    public function isIndexed(): bool
    {
        return $this->options['indexed'];
    }

    public function isNullable(): bool
    {
        return $this->options['nullable'];
    }
} 

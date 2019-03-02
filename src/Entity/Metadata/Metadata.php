<?php

namespace App\Entity\Metadata;

use App\Database\Schema\Column;
use App\Exception\Exception;

class Metadata
{
    private $class;

    private $entityManager;

    private $dataProvider;

    private $dataPersister;

    /**
     * @var Column[]
     */
    private $columns;

    /**
     * @var string
     */
    private $tableName;

    /**
     * Metadata constructor.
     *
     * @param string $class
     * @param string $entityManager
     * @param string $dataProvider
     * @param string $dataPersister
     * @param string $tableName
     * @param array  $columns
     *
     * @throws Exception
     */
    public function __construct(
        string $class,
        string $entityManager,
        string $dataProvider,
        string $dataPersister,
        string $tableName,
        array $columns
    ) {
        $this->class = $class;
        $this->entityManager = $entityManager;
        $this->dataProvider = $dataProvider;
        $this->dataPersister = $dataPersister;
        $this->columns = $columns;

        foreach ($this->columns as $column) {
            if (!$column instanceof Column) {
                throw new Exception(
                    'Only instances of "'.Column::class.'" can be used in entity metadata, given "'.get_class($column).'"'
                );
            }
        }
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getEntityManager(): string
    {
        return $this->entityManager;
    }

    /**
     * @return string
     */
    public function getDataProvider(): string
    {
        return $this->dataProvider;
    }

    /**
     * @return string
     */
    public function getDataPersister(): string
    {
        return $this->dataPersister;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return Column[]
     */
    public function getPrimaryKeys(): array
    {
        $primaryKeys = [];

        foreach ($this->columns as $property => $column) {
            if ($column->isPrimaryKey()) {
                $primaryKeys[$property] = $column;
            }
        }

        return $primaryKeys;
    }
}

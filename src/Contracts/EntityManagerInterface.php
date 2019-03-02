<?php

namespace App\Contracts;

interface EntityManagerInterface
{
    public function commit(): void;

    public function persist($entity): void;

    public function flush(): void;

    public function beginTransaction(): void;

    public function rollbackTransaction(): void;

    public function isManaged($entity): bool;
}

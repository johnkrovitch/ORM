<?php

namespace App\Database\Schema;

interface Behavior
{
    const TARGET_TYPE_TABLE = 'table';
    const TARGET_TYPE_COLUMN = 'column';

    public function getName(): string;

    public function getTargetType(): string;

    public function getTargets(): array;
}

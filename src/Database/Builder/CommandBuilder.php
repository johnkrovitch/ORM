<?php

namespace App\Database\Builder;

use App\Database\Command;

class CommandBuilder
{
    /**
     * @var Command
     */
    protected $command;

    public function __construct()
    {
        $this->command = new Command();
    }

    public function createDatabase(string $name, bool $ifNotExists = true)
    {
        $this->command->addCreateDatabase($name, [
            'if_not_exists' => $ifNotExists,
        ]);
    }

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }
}

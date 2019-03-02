<?php

namespace App\Entity\Scheduler;

class Scheduler
{
    private $scheduledForInsertions = [];

    private $scheduledForUpdates = [];

    private $scheduledForDeletions = [];

    public function scheduleForInsertion($entity)
    {
        $this->scheduledForInsertions[] = $entity;
    }

    public function scheduleForUpdate($entity, string $hash)
    {
        $this->scheduledForUpdates[$hash] = $entity;
    }

    public function isScheduled(string $hash)
    {
        if (key_exists($hash, $this->scheduledForUpdates)) {
            return true;
        }

        if (key_exists($hash, $this->scheduledForDeletions)) {
            return true;
        }

        return false;
    }
}

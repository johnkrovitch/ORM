<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent
{
    /**
     * Dispatched when a destination is synchronized.
     */
    const ORM_SCHEMA_SYNCHRONIZED = 'orm.schema.synchronisation';
    /**
     * Dispatched when a schema is loaded.
     */
    const ORM_SCHEMA_LOAD = 'orm.schema.load';
}

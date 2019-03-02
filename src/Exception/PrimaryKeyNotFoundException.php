<?php

namespace App\Exception;

use App\Entity\Metadata\Metadata;

class PrimaryKeyNotFoundException extends Exception
{
    public function __construct(Metadata $metadata)
    {
        $message = 'No primary key found for the managed entity "'.$metadata->getClass().'"';

        parent::__construct($message);
    }
}

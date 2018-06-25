<?php

namespace App\Database\Connection\Translator;

use App\Database\Command;
use App\Database\Connection\Translator\Query\TranslatedQuery;
use App\Database\Query;

interface TranslatorInterface
{
    public function translateQuery(Query $query): TranslatedQuery;
    public function translateCommand(Command $command): TranslatedQuery;
}

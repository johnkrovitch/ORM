<?php

namespace App\Database\Connection\Translator\Query;

class TranslatedQuery
{
    /**
     * @var mixed
     */
    private $translatedQuery;

    /**
     * @var array
     */
    private $parameters;

    /**
     * TranslatedQuery constructor.
     *
     * @param mixed $translatedQuery
     * @param array $parameters
     */
    public function __construct($translatedQuery, array $parameters = [])
    {
        $this->translatedQuery = $translatedQuery;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getTranslatedQuery()
    {
        return $this->translatedQuery;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}

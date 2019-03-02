<?php

namespace App\Behavior;

use App\Database\Connection\Translator;

trait HasTranslator
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param Translator $translator
     */
    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }
}

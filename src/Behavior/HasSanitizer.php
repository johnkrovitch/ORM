<?php

namespace App\Behavior;

use App\Utils\Sanitizer;

trait HasSanitizer
{
    /**
     * @var Sanitizer
     */
    protected $sanitizer;

    /**
     * @return Sanitizer
     */
    public function getSanitizer()
    {
        return $this->sanitizer;
    }

    /**
     * @param Sanitizer $sanitizer
     */
    public function setSanitizer(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }
}

<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\Utils\Sanitizer;

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
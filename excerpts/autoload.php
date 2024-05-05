<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );

return new class {
    private $paths = [
        __DIR__ . '/class-excerpt-*.php',
        __DIR__ . '/**/class-excerpt-*.php',
        __DIR__ . '/**/*.php',
        __DIR__ . '/*.php',
    ];

    public function __construct()
    {
        foreach($this->paths as $path)
        {
            foreach(glob($path) as $file) {
                require_once $file;
            }
        }
    }
};
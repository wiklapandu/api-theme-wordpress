<?php
/**
* Use for description
*
* @package HelloElementor
*/

use MI\Traits\HasModuleSystem;

defined( 'ABSPATH' ) || die( "Can't access directly" );


return new class {
    use HasModuleSystem;

    public function __construct()
    {
        $this->load([
            THEME_DIR . '/vendor/autoload.php',
            __DIR__ . '/Log.php',
            __DIR__ . '/class-helper-*.php',
            __DIR__ . '/**/class-helper-*.php',
            __DIR__ . '/class-register-*.php',
            __DIR__ . '/**/class-register-*.php',
            __DIR__ . '/*.php',
            __DIR__ . '/**/*.php',
        ]);
    }
};
<?php
use MI\Traits\HasModuleSystem;
/**
* Use for description
* Author: Wikla
*
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );
return new class {
    use HasModuleSystem;
    
    public function __construct()
    {
        $this->load([
            __DIR__ . '/**/*.php',
            __DIR__ . '/*.php',
        ]);
    }
};
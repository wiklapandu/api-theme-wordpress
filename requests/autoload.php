<?php
use MI\Traits\HasModuleSystem;
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );


return new class {
    use HasModuleSystem;

    public function __construct()
    {
        $this->load([
            __DIR__ . '/class-request-*.php'
        ]);
    }
};
<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Traits;

defined( 'ABSPATH' ) || die( "Can't access directly" );

trait HasModuleSystem
{
    public function load(array $paths = [])
    {
        foreach($paths as $path) {
            foreach(glob($path) as $file) {
                require_once $file;
            }
        }
    }
}
<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );


$paths = [
    __DIR__ . '/*.php',
    __DIR__ . '/**/*.php',
];

foreach ($paths as $path) {
    foreach (glob($path) as $file) {
        require_once $file;
    }
}
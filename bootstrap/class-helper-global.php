<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );

if(!function_exists('mi_get_config'))
{
    function mi_get_config(string $fileName): array
    {
        $fileName = str_replace('.php', '', $fileName);
        return require CONFIG_DIR . '/' . $fileName . '.php';
    }
}
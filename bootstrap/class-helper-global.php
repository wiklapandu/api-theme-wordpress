<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );

if(!function_exists('mi_get_config'))
{
    function mi_get_config(string $fileName): mixed
    {
        $fileName = str_replace('.php', '', $fileName);
        $keys = explode('.', $fileName);
        if(is_file(CONFIG_DIR . "/{$keys[0]}.php")) {
            $fileName = $keys[0];
            unset($keys[0]);
        }

        $data = require CONFIG_DIR . '/' . $fileName . '.php';

        foreach($keys as $key) {
            if(!isset($data[$key])) {
                return $data;
            }

            $data = $data[$key];
        }
        return $data;
        // return require CONFIG_DIR . '/' . $fileName . '.php';
    }
}
<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Bootstrap;

defined( 'ABSPATH' ) || die( "Can't access directly" );


trait UseSanitize
{    
    /**
     * sanitize
     *
     * @param  array $data
     * @param  array<string> $excpectedData
     * @return array
     */
    public function sanitize(array $data, array $excpectedData)
    {
        foreach($excpectedData as $key)
        {
            $data[$key] = is_string($data[$key]) ? sanitize_text_field($data[$key]) : $data[$key]; 
        }

        return $data;
    }
}
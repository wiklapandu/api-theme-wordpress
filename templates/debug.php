<?php
/**
* Template Name: Debugging
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );


$user = get_userdata(1);

echo "<pre>";
    var_dump($user);
echo "</pre>";
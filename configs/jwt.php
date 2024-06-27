<?php
/**
* Use for description
* Author: Wikla
*
*
* @package HelloElementor
*/
if(!defined('JWT_SECRET')) define('JWT_SECRET', 'Kuk!r4kur4kur4');

return [
    'secret' => JWT_SECRET,
    'hash'   => 'HS256',
    'exp'    => '1d',
];
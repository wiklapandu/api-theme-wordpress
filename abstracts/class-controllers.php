<?php
/**
* Use for description
* Author: Wikla
*
*
* @package HelloElementor
*/
namespace MI;

defined( 'ABSPATH' ) || die( "Can't access directly" );

abstract class Controllers
{
     /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        throw new \MI\Excerpts\BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }

    public static function __callStatic($method, $args)
    {
        $instance = new static;
        return $instance->{$method}($args);
    }
}
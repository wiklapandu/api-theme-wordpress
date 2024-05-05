<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Requests;

defined( 'ABSPATH' ) || die( "Can't access directly" );


class RequestPost extends \WP_REST_Request
{
    public function __construct($method = '', $route = '', $attributes = array())
    {
        parent::__construct($method, $route, $attributes);
    }

    public function running()
    {
        return wp_send_json('running....');
    }
}
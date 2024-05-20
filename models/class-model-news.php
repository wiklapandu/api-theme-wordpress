<?php
/**
* Use for description
* Author: Wikla
*
*
* @package HelloElementor
*/
namespace MI\Models;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * 
 * @property string $acf_first_name
 * */ 
class NewsModel extends \MI\WP_Model
{
    protected $type = 'post';
    protected $identify = 'news-posts';
    protected $primaryKey = 'ID';
}
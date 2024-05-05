<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Bootstrap;

defined( 'ABSPATH' ) || die( "Can't access directly" );

class PostsRegister
{
    public static function defaultLabels($label_name)
    {
        $labels = array(
			'name'                  => _x($label_name, $label_name . ' General Name', 'MI_API_THEME'),
			'singular_name'         => _x($label_name, 'Post Type Singular Name', 'MI_API_THEME'),
			'menu_name'             => __($label_name, 'MI_API_THEME'),
			'name_admin_bar'        => __($label_name, 'MI_API_THEME'),
			'archives'              => __($label_name . ' Archives', 'MI_API_THEME'),
			'attributes'            => __($label_name . ' Attributes', 'MI_API_THEME'),
			'parent_item_colon'     => __('Parent ' . $label_name . ':', 'MI_API_THEME'),
			'all_items'             => __('All ' . $label_name, 'MI_API_THEME'),
			'add_new_item'          => __('Add New ' . $label_name, 'MI_API_THEME'),
			'add_new'               => __('Add New', 'MI_API_THEME'),
			'new_item'              => __('New ' . $label_name, 'MI_API_THEME'),
			'edit_item'             => __('Edit ' . $label_name, 'MI_API_THEME'),
			'update_item'           => __('Update ' . $label_name, 'MI_API_THEME'),
			'view_item'             => __('View ' . $label_name, 'MI_API_THEME'),
			'view_items'            => __('View ' . $label_name, 'MI_API_THEME'),
			'search_items'          => __('Search ' . $label_name, 'MI_API_THEME'),
			'not_found'             => __('Not found', 'MI_API_THEME'),
			'not_found_in_trash'    => __('Not found in Trash', 'MI_API_THEME'),
			'featured_image'        => __('Featured Image', 'MI_API_THEME'),
			'set_featured_image'    => __('Set featured image', 'MI_API_THEME'),
			'remove_featured_image' => __('Remove featured image', 'MI_API_THEME'),
			'use_featured_image'    => __('Use as featured image', 'MI_API_THEME'),
			'insert_into_item'      => __('Insert into item', 'MI_API_THEME'),
			'uploaded_to_this_item' => __('Uploaded to this ' . $label_name, 'MI_API_THEME'),
			'items_list'            => __($label_name . ' list', 'MI_API_THEME'),
			'items_list_navigation' => __($label_name . ' list navigation', 'MI_API_THEME'),
			'filter_items_list'     => __('Filter ' . $label_name . ' list', 'MI_API_THEME'),
		);

		return $labels;
    }
}

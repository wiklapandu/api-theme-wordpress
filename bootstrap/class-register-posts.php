<?php
/**
* Use for description
*
* @package HelloElementor
*/

defined( 'ABSPATH' ) || die( "Can't access directly" );


return new class {
	public function __construct()
	{
		$this->initialing();
	}

    public function initialing()
    {
        $post_types = mi_get_config('posts-type');
        
        foreach($post_types as $post_type => $args) {
			$args = wp_parse_args($args, $this->defaultArgs('Post Type ' . $post_type, $post_type));
            $default = \MI\Bootstrap\PostsRegister::defaultLabels($args['label']);
			
            $args['labels'] = wp_parse_args($args['labels'], $default);
            register_post_type($post_type, $args);
        }
    }

    public function defaultArgs($label_name, $slug)
    {
        $args = array(
			'label'                 => __($label_name, 'MI_API_THEME'),
			'description'           => __($label_name . ' Description', 'MI_API_THEME'),
			'labels'                => [],
			'supports'              => array('title', 'editor', 'thumbnail'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_icon'             => 'dashicons-admin-post',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => array('slug' => $slug),
			'capability_type'       => 'page',
		);
		return $args;
    }
};
<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Nooovle Theme' );
define( 'CHILD_THEME_URL', 'http://www.nooovle.com/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'dd_google_fonts' );
function dd_google_fonts() {

	wp_enqueue_style( 'dashicons', get_stylesheet_directory_uri(), array( 'dashicons' ), '1.0' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Abel', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3', false);
	wp_enqueue_script( 'backstretch', '//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js', array('jquery'), CHILD_THEME_VERSION, true);
	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js/global.js', array('jquery'), CHILD_THEME_VERSION, true);

	$dd_global = array( 'template_url' => get_stylesheet_directory_uri() );

	wp_localize_script('global', 'dd_global', $dd_global);

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Add image sizes
// add_image_size( 'design thumbnail', 345, 217, true );

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	// 'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

// remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
// remove_action( 'genesis_footer', 'genesis_do_footer' );
// remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

/*
* Remove unused functions
*
*/

unregister_sidebar( 'header-right' );

/*
* Relocations ^_^
*
*/

remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

/*
* Filters and hooks
*
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

add_filter( 'comment_form_defaults', 'dd_remove_comment_form_allowed_tags' );
add_action( 'the_posts', 'dd_prime_post_thumbnails_cache', 10, 2 );

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'dd_footer' );

add_filter( 'widget_text', 'do_shortcode');

/*
* Functions
*
*/

function dd_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

function dd_footer() {
	genesis_widget_area( 'footer-social', array(
		'before' => '<div class="footer-social widget-area">',
		'after' => '</div>'
	));

	echo '<div class="creds widget-area">Copyright '. do_shortcode('[footer_copyright]') .' &middot; Nooovle &middot; All rights reserved.</div>';
}

function dd_prime_post_thumbnails_cache( $posts, $wp_query ) {
	// Prime the cache for the main front page and archive loops by default.
	$is_main_archive_loop = $wp_query->is_main_query() && ! is_singular();
	$do_prime_cache = apply_filters( 'dd_cache_post_thumbnails', $is_main_archive_loop );
	if ( ! $do_prime_cache && ! $wp_query->get( 'dd_cache_post_thumbnails' ) ) {
		return $posts;
	}

	update_post_thumbnail_cache( $wp_query );
	return $posts;
}

// Register custom post types
add_action( 'init', 'dd_post_type' );
function dd_post_type() {
		register_post_type( 'client',
			array(
				'labels' => array(
					'name' => __( 'Clients' ),
					'singular_name' => __( 'Client' ),
					'add_new_item' => 'Add New Client',
					'add_new' => 'Add Client',
					'edit_item' => 'Edit Client',
					'new_item' => 'New Client',
					'view_item' => 'View Client'
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'client'),
				'supports' => array( 'title', 'genesis-seo', 'thumbnail', 'custom-fields' ),
				'menu_icon' => 'dashicons-groups',
				'menu_position' => 5,
				'publicly_queryable' => true,
				'hierarchical' => true,
				// 'taxonomies' => array('service'),
				'capability_type' => 'post'
			)
		);

		register_post_type( 'testimonial',
			array(
				'labels' => array(
					'name' => __( 'Testimonials' ),
					'singular_name' => __( 'Testimonial' ),
					'add_new_item' => 'Add New Testimonial',
					'add_new' => 'Add Testimonial',
					'edit_item' => 'Edit Testimonial',
					'new_item' => 'New Testimonial',
					'view_item' => 'View Testimonial'
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'testimonial'),
				'supports' => array( 'title','editor', 'genesis-seo', 'thumbnail', 'custom-fields' ),
				'menu_icon' => 'dashicons-admin-comments',
				'menu_position' => 5,
				'publicly_queryable' => true,
				'hierarchical' => true,
				// 'taxonomies' => array('service'),
				'capability_type' => 'post'
			)
		);
}

add_action ('init', 'dd_custom_tax');
function dd_custom_tax() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Services', 'taxonomy general name' ),
		'singular_name'     => _x( 'Service', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Services' ),
		'all_items'         => __( 'All Services' ),
		'parent_item'       => __( 'Service' ),
		'parent_item_colon' => __( 'Service:' ),
		'edit_item'         => __( 'Edit Service' ),
		'update_item'       => __( 'Update Service' ),
		'add_new_item'      => __( 'Add New Service' ),
		'new_item_name'     => __( 'New Service Name' ),
		'menu_name'         => __( 'Services' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'service' ),
	);

	register_taxonomy( 'service', array( 'client' ), $args );

}

// Registered Sidebar
genesis_register_sidebar( array(
	'id' => 'nooovle_video',
	'name' => 'Nooovle Video',
	'description' => 'Nooovle video widget'
));
genesis_register_sidebar( array(
	'id' => 'home-featured-1',
	'name' => 'Home Featured 1',
	'description' => 'Home featured 1 widget'
));
genesis_register_sidebar( array(
	'id' => 'home-featured-2',
	'name' => 'Home Featured 2',
	'description' => 'Home featured 2 widget'
));
genesis_register_sidebar( array(
	'id' => 'testimonials',
	'name' => 'Home Testimonials',
	'description' => 'Home testimonials widget'
));
genesis_register_sidebar( array(
	'id' => 'clients',
	'name' => 'Home Clients',
	'description' => 'Home clients widget'
));
genesis_register_sidebar( array(
	'id' => 'blog',
	'name' => 'Home Blog',
	'description' => 'Home blog widget'
));
genesis_register_sidebar( array(
	'id' => 'blog',
	'name' => 'Home Blog',
	'description' => 'Home blog widget'
));
genesis_register_sidebar( array(
	'id' => 'portfolio',
	'name' => 'Home Porfolio',
	'description' => 'Home portfolio widget'
));
genesis_register_sidebar( array(
	'id' => 'footer-social',
	'name' => 'Footer Social',
	'description' => 'Footer social widget'
));






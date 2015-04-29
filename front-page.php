<?php

add_filter( 'genesis_pre_get_site_option_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_header', 'dd_nooovle_header' );
add_action( 'genesis_after_header', 'dd_nooovle_feature' );

/**
 * Add in ScrollReveal.js in a Genesis Theme
 *
 * @package   Add in ScrollReveal.js in a Genesis Theme
 * @author    Neil Gee
 * @link      http://wpbeaches.com/using-scrollreveal-js-wordpress-genesis-theme/
 * @copyright (c)2014, Neil Gee
 **/



//Enqueue the ScrollReveal main script
function dd_scroll_reveal() {

 wp_enqueue_script ('scrollreveal', get_stylesheet_directory_uri() . '/js/scrollReveal.min.js', array( 'jquery' ),'2.0.5',true );
}
add_action( 'wp_enqueue_scripts', 'dd_scroll_reveal' );


//Optional - Initially hide data-sr elements whilst page loads
function dd_scroll_reveal_inlinecss() {
?>
<style> [data-sr] { visibility: hidden; } </style>
<?

}
add_action( 'wp_head','dd_scroll_reveal_inlinecss' );

// function dd_attr_entry_image_scrollreveal( $attributes ){

//  // add scrollreveal data-sr
//     $attributes['data-sr'] = 'enter left, move 100%, reset';

//     // return the attributes
//     return $attributes;

// }
// add_filter( 'genesis_attr_entry', 'dd_attr_entry_image_scrollreveal' );


function dd_nooovle_header() {

	echo '<div class="nooovle-header">';

		genesis_widget_area( 'custom-header-left', array(
			'before' => '<div class="custom-header-left widget-area">',
			'after'  => '</div>'
		));

		genesis_widget_area( 'custom-header-right', array(
			'before' => '<div class="custom-header-right widget-area">',
			'after'  => '</div>'
		));

	echo '</div>';

}

function dd_nooovle_feature() {

		genesis_widget_area( 'brief', array(
			'before' => '<div data-sr id="about" class="brief widget-area light"><div class="wrap">',
			'after'  => '</div></div>'
		));

		genesis_widget_area( 'what-we-do', array(
			'before' => '<div data-sr id="what-we-do" class="what-we-do widget-area gray"><div class="wrap">',
			'after'  => '</div></div>'
		));

		genesis_widget_area( 'watch-video', array(
			'before' => '<div data-sr id="watch-video" class="watch-video widget-area light"><div class="wrap">',
			'after'  => '</div></div>'
		));

		genesis_widget_area( 'awesome-works', array(
			'before' => '<div data-sr id="awesome-works" class="awesome-works widget-area gray"><div class="wrap">',
			'after'  => '</div></div>'
		));

		genesis_widget_area( 'trusted', array(
			'before' => '<div data-sr id="trusted" class="trusted widget-area light"><div class="wrap">',
			'after'  => '</div></div>'
		));

		genesis_widget_area( 'ready-to-help', array(
			'before' => '<div data-sr id="ready-to-help" class="ready-to-help widget-area">',
			'after'  => '</div>'
		));

		genesis_widget_area( 'contact-us', array(
			'before' => '<div data-sr id="contact-us" class="contact-us widget-area light">',
			'after' => '</div>'
		));
}

genesis();
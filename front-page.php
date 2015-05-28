<?php

add_filter( 'genesis_pre_get_site_option_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_header', 'dd_nooovle_video' );
function dd_nooovle_video() {
	genesis_widget_area( 'nooovle_video', array(
		'before' => '<div class="nooovle-video widget-area">',
		'after' => '</div>'
	));
}

add_action( 'genesis_after_header', 'dd_home_featured' );

function dd_home_featured() {

// About and Services
echo '<div class="about"><div class="wrap">';
	genesis_widget_area( 'home-featured-1', array(
		'before' => '<div id="about" class="home-featured-1 widget-area">',
		'after' => '</div>'
	));

	genesis_widget_area( 'home-featured-2', array(
		'before' => '<div id="services" class="home-featured-2 widget-area">',
		'after' => '</div>'
	));
echo '</div></div>';

// Testimonials
echo '<div id="testimonails" class="testimonial"><div class="wrap">';
	genesis_widget_area( 'testimonials', array(
		'before' => '<div class="home-testimonials widget-area">',
		'after' => '</div>'
	));

	echo '<div class="thumbnail-testimonials widget-area"><img src="'. get_stylesheet_directory_uri() .'/images/thumbnail-testimonial.jpg" width="800" height="560" /></div>';
echo '</div></div>';

// Clients
echo '<div id="clients" class="home-clients">';
	// genesis_widget_area( 'clients', array(
	// 	'before' => '<div class="home-clients widget-area"><div class="wrap">',
	// 	'after' => '</div></div>'
	// ));

		$args = array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> 'client',
			'orderby'			=> 'rand',
			// 'order'				=> 'ASC',
			'nopaging' 			=> true
		);

		// get results
		$the_query = new WP_Query( $args );

		// The Loop
		?>
		<?php if( $the_query->have_posts() ): ?>


			<div class="wrap">
				<h4 class="widget-title widgettitle">Clients</h4>
					<ul class="client-list">
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li class="client">
							<?php genesis_image( array('size' => 'full')); ?>
						</li>
					<?php endwhile; ?>
					</ul>
			</div>

		<?php endif; ?>

		<?php wp_reset_query();  // Restore global post data stomped by the_post().
echo '</div>';

// Blog
echo '<div id="blog" class="blog-items"><div class="wrap">';
	echo '<div class="thumbnail-blog widget-area"><img src="'. get_stylesheet_directory_uri() .'/images/thumbnail-blog.jpg" width="800" height="560" /></div>';

	genesis_widget_area( 'blog', array(
		'before' => '<div class="home-blog widget-area">',
		'after' => '</div>'
	));

echo '</div></div>';

// Gallery
// echo '<div class="portfolio">';
	genesis_widget_area( 'portfolio', array(
		'before' => '<div class="home-portfolio widget-area"><div class="wrap">',
		'after' => '</div></div>'
	));
// echo '</div>';

echo '<div class="clearfix"></div>';

}


genesis();
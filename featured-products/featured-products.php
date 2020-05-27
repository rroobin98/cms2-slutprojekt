<?php
/*
Plugin Name: featuredproducts
Description: Visar 8 featured produkter
Version: 1.0
Author: Robin Lundström
*/

add_shortcode( 'featuredproducts', 'featuredproducts' );
function featuredproducts($atts){
	global $woocommerce_loop;



	extract(shortcode_atts(array(
		'tax' => 'product_cat',
		'per_cat' => '8',
		'columns' => '4',
	), $atts));


	// startar output buffering
	ob_start();


	// setup query
	$args = array(
		'post_type' 			=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page'		=> $per_cat,
		'terms'    => 'featured',
		'orderby' 		 		=> 'meta_value_num'
	);

	// ställa in woocommerce-kolumner
	$woocommerce_loop['columns'] = $columns;

	// query databas
	$products = new WP_Query( $args );

  	// Loopen som visar featured
	if ( $products->have_posts() ) : ?>
		<?php woocommerce_product_loop_start(); ?>
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile;  ?>
		<?php woocommerce_product_loop_end(); ?>
	<?php endif;
	wp_reset_postdata();

  //  html output - buffer output
	return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}
?>

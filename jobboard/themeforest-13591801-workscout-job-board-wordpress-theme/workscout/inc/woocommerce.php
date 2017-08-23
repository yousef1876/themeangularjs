<?php 

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}


remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_add_to_cart', 10 );

add_filter( 'woocommerce_show_page_title', function() { return false; } );



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	    woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
	}
}

add_filter( 'woocommerce_output_related_products_args', function( $args ) 
{ 
    $args = wp_parse_args( array( 'posts_per_page' => 3 ), $args );
    return $args;
});

 ?>
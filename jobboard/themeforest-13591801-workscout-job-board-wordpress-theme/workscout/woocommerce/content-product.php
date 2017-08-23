<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}


// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();



$pricingtable_mode = Kirki::get_option( 'workscout', 'pp_pricingtable_mode' );

if($pricingtable_mode) { 

	$layout = Kirki::get_option( 'workscout', 'pp_shop_layout' ); 
	if($layout=='full-width'){ 

		$classes[] = 'plan columns one-third';
		$woocommerce_loop['columns'] = 3;

	} else {

		$classes[] = 'plan columns half';
		$woocommerce_loop['columns'] = 2;

	}

	if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
		$classes[] = 'first alpha';
	}
	if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
		$classes[] = 'last omega';
	}
	
	if($product->is_featured()) { 
		$classes[] = "color-2 "; 
	} else { 
		$classes[] = "color-1 "; 
	} 

?>

<div <?php post_class( $classes ); ?>>
	
	<?php if($product->product_type == "job_package") { ?>
		<div class="plan-price">

			<h3><?php the_title(); ?></h3>
			<div class="plan-price-wrap"><?php echo $product->get_price_html(); ?></div>

		</div>

		<div class="plan-features">

			<ul>
				<?php 
				$jobslimit = $product->get_limit();
				if(!$jobslimit){
					echo "<li>";
					esc_html_e('Unlimited number of jobs','workscout'); 
					echo "</li>";
				} else { ?>
				<li>
					<?php esc_html_e('This plan includes ','workscout'); printf( _n( '%d job', '%s jobs', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
				</li>
				<?php } ?>
				
				<li>
					<?php esc_html_e('Jobs are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'workscout' ), $product->get_duration() ); ?>
				</li>

			</ul>

			<?php 
				the_content(); 
				$link 	= $product->add_to_cart_url();
				$label 	= apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) );
			?>
			<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo $label; ?></a>
			
		</div>
	<?php } else { ?>
		<div class="plan-price">

			<h3><?php the_title(); ?></h3>
			<div class="plan-price-wrap"><?php echo $product->get_price_html(); ?></div>

		</div>
		<div class="plan-features">
			<span class="product-category">
			<?php
			echo woocommerce_get_product_thumbnail('workscout-small-blog');
				$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
				if ( $product_cats && ! is_wp_error ( $product_cats ) ){
					$single_cat = array_shift( $product_cats );
					echo $single_cat->name;
				} 
			?>
			</span>
			<?php 
			$link 	= $product->add_to_cart_url();
			$label 	= apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) );
			?>
			<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo $label; ?></a>
			
			<?php	do_action( 'woocommerce_after_shop_loop_item_title' );	?>
		</div>
	<?php }	?>
</div>

<?php } else { 

	if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
		$classes[] = 'first alpha';
	}
	if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
		$classes[] = 'last omega';
	}?>
	<li <?php post_class( $classes ); ?>>
		
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<a href="<?php the_permalink(); ?>">
			<div class="mediaholder">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			</div>

			<section>
				<span class="product-category">
				<?php
					$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
					if ( $product_cats && ! is_wp_error ( $product_cats ) ){
					$single_cat = array_shift( $product_cats );
					echo $single_cat->name;
					} ?>
				</span>

				<h5><?php the_title(); ?></h5>
				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</section>
		</a>

		<?php

			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );

		?>

	</li>
<?php } ?>
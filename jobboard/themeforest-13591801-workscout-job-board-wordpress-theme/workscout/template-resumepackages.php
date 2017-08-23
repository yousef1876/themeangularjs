<?php
/**
 * Template Name: Page Template Resume Packages (WooCommerce)
 *
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */

get_header();

?>

<div id="titlebar" class="single">
	<div class="container">
		<div class="sixteen columns">
			<h1><?php the_title(); ?></h1>
	        <?php if(function_exists('bcn_display')) { ?>
		        <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<ul>
			        	<?php bcn_display_list(); ?>
			        </ul>
				</nav>
			<?php } ?>
		</div>
	</div>
</div>

<div class="container">
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('sixteen columns'); ?>>
		<?php the_content(); ?>
	</article>


<?php endwhile; // End of the loop. ?>

<?php 
global $wp_query;

$job_packages = new WP_Query( array(
	'post_type'  => 'product',
	'limit'      => -1,
	'tax_query'  => array(
		array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => 'resume_package'
		)
	)
) );
 ?>
	<article <?php post_class(); ?>>

		<?php 
		switch ($job_packages->found_posts) {
			case 2:
				$columns = "eight";
				break;		
			case 3:
				$columns = "one-third";
				break;			
			case 4:
				$columns = "four";
				break;
			
			default:
				$columns = "one-third";
				break;
		}
		
		while ( $job_packages->have_posts() ) : $job_packages->the_post(); 
		

			$job_package = get_product( get_post()->ID ); ?>
		
			<div class="plan <?php if($job_package->is_featured()) { echo "color-2 "; } else { echo "color-1 "; } echo esc_attr($columns); ?>  column">
				<div class="plan-price">

					<h3><?php the_title(); ?></h3>
					<?php echo '<div class="plan-price-wrap">'.$job_package->get_price_html().'</div>'; ?>

				</div>

				<div class="plan-features">
					<ul>
						<?php 
						$jobslimit = $product->get_limit();
						if(!$jobslimit){
							echo "<li>";
							 esc_html_e('Unlimited number of resumes','workscout'); 
							 echo "</li>";
						} else { ?>
							<li>
								<?php esc_html_e('This plan includes ','workscout'); printf( _n( '%d job', '%s jobs', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
							</li>
						<?php } ?>
						<li>
							<?php esc_html_e('Resumes are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $job_package->get_duration(), 'workscout' ), $job_package->get_duration() ); ?>
						</li>

					</ul>
					<?php 
						the_content(); 
						$link 	= $job_package->add_to_cart_url();
					?>
					<a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) ); ?></a>
					
				</div>
			</div>
		<?php endwhile; ?>
	</article>
</div>

<?php
get_footer(); ?>
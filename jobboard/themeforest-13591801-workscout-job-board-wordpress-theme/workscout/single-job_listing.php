<?php
/**
 * The template for displaying all single jobs.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WorkScout
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<!-- Titlebar
================================================== -->
<?php 
$header_image = get_post_meta($post->ID, 'pp_job_header_bg', TRUE); 

if(!empty($header_image)) { ?>
	<div id="titlebar" class="photo-bg" style="background: url('<?php echo esc_url($header_image); ?>')">
<?php } else { ?>
	<div id="titlebar">
<?php } ?>

		<div class="container">
			<div class="ten columns">
		
			<?php
			$terms = get_the_terms( $post->ID, 'job_listing_category' );
									
			if ( $terms && ! is_wp_error( $terms ) ) : 

				$jobcats = array();
			 	
				foreach ( $terms as $term ) {
					$term_link = get_term_link( $term );
					$jobcats[] = '<a href="'.$term_link.'">'.$term->name.'</a>';
				}
									
				$print_cats = join( " / ", $jobcats ); ?>
			 	<?php echo '<span>'.$print_cats.'</span>'; ?>
			<?php 
			endif; ?>
				<h2><?php the_title(); ?> 
					<span class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>"><?php the_job_type(); ?></span><?php if(workscout_newly_posted()) { echo '<span class="new_job">'.esc_html__('NEW','workscout').'</span>'; } ?>
				</h2>
			</div>

			<div class="six columns">
			<?php do_action('workscout_bookmark_hook') ?>
				
			</div>

		</div>
	</div>


<!-- Content
================================================== -->
<div class="container">

<?php if(class_exists( 'WP_Job_Manager_Applications' )) : ?>		
	<?php if ( user_has_applied_for_job( get_current_user_id(), $post->ID ) ) { ?>
		<div class="sixteen columns">
			<?php get_job_manager_template( 'applied-notice.php', array(), 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/' ); ?>
		</div>
	<?php } ?>
	<?php if ( is_position_filled() ) : ?>
			<div class="sixteen columns"><div class="notification closeable notice "><?php esc_html_e( 'This position has been filled', 'workscout' ); ?></div><div class="margin-bottom-35"></div></div>	
	<?php elseif ( ! candidates_can_apply() && 'preview' !== $post->post_status ) : ?>
			<div class="sixteen columns"><div class="notification closeable notice "><?php esc_html_e( 'Applications have closed', 'workscout' ); ?></div></div>	
	<?php endif; ?>
<?php  endif;  ?>

	<!-- Recent Jobs -->
	<div class="eleven columns">
		<div class="padding-right">
			<?php if ( get_the_company_name() ) { ?>
				<!-- Company Info -->
				<div class="company-info" itemscope itemtype="http://data-vocabulary.org/Organization">
					<?php if(class_exists('Astoundify_Job_Manager_Companies')) { echo workscout_get_company_link(the_company_name('','',false)); } ?>
						<?php the_company_logo(); ?></a>
					<?php if(class_exists('Astoundify_Job_Manager_Companies')) { echo "</a>"; } ?>
					<div class="content">
						<h4>
							<?php if(class_exists('Astoundify_Job_Manager_Companies')) { echo workscout_get_company_link(the_company_name('','',false)); } ?>
							<?php the_company_name( '<strong itemprop="name">', '</strong>' ); ?> 
							<?php if(class_exists('Astoundify_Job_Manager_Companies')) { echo "</a>"; } ?>
						<?php the_company_tagline( '<span class="company-tagline">- ', '</span>' ); ?></h4>
						<?php if ( $website = get_the_company_website() ) : ?>
							<span><a class="website" href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><i class="fa fa-link"></i> <?php esc_html_e( 'Website', 'workscout' ); ?></a></span>
						<?php endif; ?>
						<?php if ( get_the_company_twitter() ) : ?>
							<span><a href="http://twitter.com/<?php echo get_the_company_twitter(); ?>">
								<i class="fa fa-twitter"></i>
								@<?php echo get_the_company_twitter(); ?>
							</a></span>
						<?php endif; ?>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
		<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
			<div class="job-manager-info"><?php esc_html_e( 'This listing has expired.', 'workscout' ); ?></div>
		<?php endif; ?>
			
			<div class="single_job_listing" itemscope itemtype="http://schema.org/JobPosting">
				<meta itemprop="title" content="<?php echo esc_attr( $post->post_title ); ?>" />

				<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
					<div class="job-manager-info"><?php esc_html_e( 'This listing has expired.', 'workscout' ); ?></div>
				<?php else : ?>
					<div class="job_description" itemprop="description">
						<?php the_company_video(); ?>
						<?php echo do_shortcode(apply_filters( 'the_job_description', get_the_content() )); ?>
					</div>
					<?php
						/**
						 * single_job_listing_end hook
						 */
						do_action( 'single_job_listing_end' );
					?>

				<?php endif; ?>
			</div>

		</div>
	</div>


	<!-- Widgets -->
	<div class="five columns">
		<?php dynamic_sidebar( 'sidebar-job-before' ); ?>
		<!-- Sort by -->
		<div class="widget">
			<h4><?php esc_html_e('Job Overview','workscout') ?></h4>

			<div class="job-overview">
				<?php do_action( 'single_job_listing_meta_before' ); ?>
				<ul>
					<?php do_action( 'single_job_listing_meta_start' ); ?>
					<li>
						<i class="fa fa-calendar"></i>
						<div>
							<strong><?php esc_html_e('Date Posted','workscout'); ?>:</strong>
							<span><?php printf( esc_html__( 'Posted %s ago', 'workscout' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
						</div>
					</li>
					<?php 
					$expired_date = get_post_meta( $post->ID, '_job_expires', true );
					$hide_expiration = get_post_meta( $post->ID, '_hide_expiration', true );
					
					if(empty($hide_expiration )) {
						if(!empty($expired_date)) { ?>
					<li>
						<i class="fa fa-calendar"></i>
						<div>
							<strong><?php esc_html_e('Expiration date','workscout'); ?>:</strong>
							<span><?php echo date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $post->ID, '_job_expires', true ) ) ) ?></span>
						</div>
					</li>
					<?php }
					} ?>

					<?php 
					if ( $deadline = get_post_meta( $post->ID, '_application_deadline', true ) ) {
						$expiring_days = apply_filters( 'job_manager_application_deadline_expiring_days', 2 );
						$expiring = ( floor( ( time() - strtotime( $deadline ) ) / ( 60 * 60 * 24 ) ) >= $expiring_days );
						$expired  = ( floor( ( time() - strtotime( $deadline ) ) / ( 60 * 60 * 24 ) ) >= 0 );

						echo '<li class="ws-application-deadline ' . ( $expiring ? 'expiring' : '' ) . ' ' . ( $expired ? 'expired' : '' ) . '"><i class="fa fa-calendar"></i>
						<div>
							<strong>' . ( $expired ? __( 'Closed', 'workscout' ) : __( 'Closes', 'workscout' ) ) . ':</strong><span>' . date_i18n( __( 'M j, Y', 'workscout' ), strtotime( $deadline ) ) . '</span></div></li>';
					} ?>
					<li>
						<i class="fa fa-map-marker"></i>
						<div>
							<strong><?php esc_html_e('Location','workscout'); ?>:</strong>
							<span class="location" itemprop="jobLocation"><?php the_job_location(); ?></span>
						</div>
					</li>
					<li>
						<i class="fa fa-user"></i>
						<div>
							<strong><?php esc_html_e('Job Title','workscout'); ?>:</strong>
							<span><?php the_title(); ?></span>
						</div>
					</li>
					<?php $hours = get_post_meta( $post->ID, '_hours', true ); 
					 if ( $hours ) { ?>
					<li>
						<i class="fa fa-clock-o"></i>
						<div>
							<strong><?php esc_html_e('Hours','workscout'); ?>:</strong>
							<span><?php echo esc_html( $hours ) ?><?php esc_html_e('h / week','workscout'); ?></span>
						</div>
					</li>
					<?php } ?>

					<?php $rate_min = get_post_meta( $post->ID, '_rate_min', true ); 
					 if ( $rate_min ) { 
					 	$rate_max = get_post_meta( $post->ID, '_rate_max', true );  ?>
					<li>
						<i class="fa fa-money"></i>
						<div>
							<strong><?php esc_html_e('Rate:','workscout'); ?></strong>
							<span>				
								<?php echo get_workscout_currency_symbol(); echo esc_html( $rate_min ) ?> <?php if(!empty($rate_max)) { echo '- '.$rate_max; } ?><?php esc_html_e(' / hour','workscout'); ?>
							</span>
						</div>
					</li>
					<?php } ?>
					
					<?php $salary = get_post_meta( $post->ID, '_salary_min', true ); 
					 if ( $salary ) { 
						$salary_max = get_post_meta( $post->ID, '_salary_max', true ); 
					 	?>
					<li>
						<i class="fa fa-money"></i>
						<div>
							<strong><?php esc_html_e('Salary:','workscout'); ?></strong>
							<span><?php  echo get_workscout_currency_symbol();  echo esc_html( $salary ) ?> - <?php echo esc_html($salary_max); ?></span>
						</div>
					</li>
					<?php } ?>
					<?php do_action( 'single_job_listing_meta_end' ); ?>
				</ul>
				
				<?php do_action( 'single_job_listing_meta_after' ); ?>
				
				<?php if ( candidates_can_apply() ) : ?>
					<?php 
						$external_apply = get_post_meta( $post->ID, '_apply_link', true ); 
						if(!empty($external_apply)) {
							echo '<a class="button" target="_blank" href="'.esc_url($external_apply).'">'.esc_html__( 'Apply for job', 'workscout' ).'</a>';
						} else {
							get_job_manager_template( 'job-application.php' ); 
						}
					?>
					
				<?php endif; ?>

				
			</div>

		</div>
		<?php dynamic_sidebar( 'sidebar-job-after' ); ?>

	</div>
	<!-- Widgets / End -->


</div>
<div class="clearfix"></div>
<div class="margin-top-55"></div>

<?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>

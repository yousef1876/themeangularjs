<?php
/**
 * Job Category
 *
 * @package Jobify
 * @since Jobify 1.0
 */



get_header(); ?>
<div id="titlebar" class="single">
	<div class="container">
		<div class="sixteen columns">
			<div class="ten columns">
				<?php 
				$count_jobs = wp_count_posts( 'job_listing', 'readable' );
				?>
				<span>
				<?php printf( esc_html__( 'We have %s job offers for you', 'workscout' ), '<em class="count_jobs">' . $count_jobs->publish . '</em>' ) ?>
				</span>
				<h2 class="showing_jobs"><?php esc_html_e('Showing All Jobs','workscout') ?></h2>
			</div>
			<?php if(get_option('workscout_enable_add_job_button')) { ?>
		        <div class="six columns">
					<a href="<?php echo get_permalink(get_option('job_manager_submit_job_form_page_id')); ?>" class="button"><?php esc_html_e('Post a Job, It\'s Free!','workscout'); ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>


<?php 
	$layout = Kirki::get_option( 'workscout', 'pp_blog_layout' );
	if(empty($layout)) { $layout = 'right-sidebar'; }
	wp_dequeue_script('wp-job-manager-ajax-filters' );
	wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );
?>

<div class="container <?php echo esc_attr($layout); ?>">

	<article id="post-<?php the_ID(); ?>" <?php post_class('eleven columns'); ?>>
		<div class="padding-right">
			<?php 
			if ( ! empty( $_GET['search_keywords'] ) ) {
				$keywords = sanitize_text_field( $_GET['search_keywords'] );
			} else {
				$keywords = '';
			}
			?>
			<form class="list-search"  method="GET" action="">
				<div class="search_keywords">
					<button><i class="fa fa-search"></i></button>
					<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
					<div class="clearfix"></div>
				</div>
			</form>

			<?php echo do_shortcode('[jobs show_filters="false"]'); ?>
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</article>
	<?php  get_sidebar('jobs');?>

</div>
<?php get_footer(); ?>


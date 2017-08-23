
	<!-- Titlebar
================================================== -->
<div id="titlebar" class="single">
	<div class="container">
		<div class="sixteen columns">
			<div class="ten columns">
				<?php $count_jobs = wp_count_posts( 'resume', 'readable' );	?>
				<span><?php printf( esc_html__( 'We have %s resumes in our database', 'workscout' ), $count_jobs->publish ) ?></span>
				<h2 class="showing_jobs"><?php esc_html_e('Showing all resumes','workscout') ?></h2>
			</div>

			<?php if(get_option('workscout_enable_add_resume_button')) { ?>
	        <div class="six columns">
				<a href="<?php echo get_permalink(get_option('resume_manager_submit_resume_form_page_id')); ?>" class="button"><?php esc_html_e("Post a Resume, It's Free!",'workscout'); ?></a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
	$layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);
	if(empty($layout)) { $layout = 'right-sidebar'; }
	
	wp_enqueue_script( 'workscout-wp-resume-manager-ajax-filters' );
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
			<form class="list-search"  method="GET" action="<?php echo get_permalink(get_option('resume_manager_resumes_page_id')); ?>">
				<div class="search_resumes">
					<button><i class="fa fa-search"></i></button>
					<input type="text" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'Search freelancer services (e.g. logo design)', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
					<div class="clearfix"></div>
				</div>
			</form>

			<?php echo do_shortcode('[resumes show_filters="false" show_pagination="true"]')?>
			<footer class="entry-footer">
				<?php edit_post_link( esc_html__( 'Edit', 'workscout' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</article>
	<?php  get_sidebar('resumes');?>

</div>
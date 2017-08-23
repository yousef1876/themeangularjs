<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WorkScout
 */

get_header(); ?>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="single">
	<div class="container">

		<div class="sixteen columns">
			<h2><?php echo Kirki::get_option( 'workscout', 'pp_blog_title' ); ?></h2>
			<span><?php echo Kirki::get_option( 'workscout', 'pp_blog_subtitle' ); ?></span>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<?php $layout = get_post_meta($post->ID, 'pp_sidebar_layout', true); ?>

<div class="container <?php echo esc_attr($layout); ?>">

	<!-- Blog Posts -->
	<div class="eleven columns">
		<div class="padding-right">

		<?php while ( have_posts() ) : the_post(); ?>

	
			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(array(
		        'prev_text'          => '<i class="fa fa-chevron-left"></i>  %title',
		        'next_text'          => '%title <i class="fa fa-chevron-right"></i>',
		        'screen_reader_text' => esc_html__( 'Post navigation','workscout' ),
		    )); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

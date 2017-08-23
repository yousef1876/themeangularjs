<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WorkScout
 */

get_header(); ?>

	<!-- Titlebar
	================================================== -->
	<div id="titlebar" class="single submit-page">
		<div class="container">

			<div class="sixteen columns">
				<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'workscout' ); ?></h1>
			</div>

		</div>
	</div>

	<div class="container full-width">
		<article id="post-<?php the_ID(); ?>">
			<div class="columns sixteen">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'workscout' ); ?></p>
				<?php get_search_form(); ?>
				<div class="margin-bottom-25"></div>
			</div>
			
			<div class="columns one-third"><?php the_widget( 'WP_Widget_Recent_Posts' ); ?></div>
					
			<div class="columns one-third"><?php if ( workscout_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'workscout' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>
			</div>

			<div class="columns one-third">

				<?php
					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'workscout' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
				?>

				<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
			</div>
		</article>
	</div>
<?php get_footer(); ?>

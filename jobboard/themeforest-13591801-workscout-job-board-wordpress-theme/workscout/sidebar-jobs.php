<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */


?>
<!-- Widgets -->
<div class="five columns sidebar"  role="complementary">
<form class="job_filters in_sidebar">
	<?php 
		if ( ! empty( $_GET['search_keywords'] ) ) {
			$keywords = sanitize_text_field( $_GET['search_keywords'] );
		} else {
			$keywords = '';
		}
	?>
	<input type="hidden" name="search_keywords" id="search_keywords" placeholder="<?php esc_attr_e( 'job title, keywords or company name', 'workscout' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
	
	<div class="job_filters_links"></div>
	<?php if(get_query_var( 'company')) {?>
		<input type="hidden" name="company_field" value="<?php echo urldecode( get_query_var( 'company') ) ?>">
	<?php } ?>
	<?php if(get_option('workscout_enable_location_sidebar') == 1) { ?>
		<div class="widget">
			<h4><?php esc_html_e('Location','workscout'); ?></h4>
			<div class="search_location">
				<?php 
				if ( ! empty( $_GET['search_location'] ) ) {
					$location = sanitize_text_field( $_GET['search_location'] );
				} else {
					$location = '';
				} ?>
				<input type="text" name="search_location" id="search_location" placeholder="<?php esc_attr_e( 'Location', 'workscout' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
				
			</div>
		</div>
	<?php } ?>
	
	<?php if(get_option('workscout_enable_location_sidebar') == 1) { ?>
		<div class="widget">
			<h4><?php esc_html_e('Job type','workscout'); ?></h4>
			<?php get_job_manager_template( 'job-filter-job-types.php', array( 'job_types' => '', 'atts' => '', 'selected_job_types' => '' ) ); ?>
		</div>
	<?php } ?>


	<?php 
	if ( ! is_tax( 'job_listing_category' ) && get_terms( 'job_listing_category' ) ) :
		$show_category_multiselect = get_option( 'job_manager_enable_default_category_multiselect', false ); 

		if ( ! empty( $_GET['search_category'] ) ) {
			$selected_category = sanitize_text_field( $_GET['search_category'] );
		} else {
			$selected_category = "";
		}
		?>
		<div class="widget">
			<h4><?php esc_html_e('Category','workscout'); ?></h4>
			<div class="search_categories">
				
				<?php if ( $show_category_multiselect ) : ?>
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'hide_empty' => false ) ); ?>
				<?php else : ?>
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'show_option_all' => esc_html__( 'Any category', 'workscout' ), 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'multiple' => false ) ); ?>
				<?php endif; ?>
				
			</div>
		</div>
	<?php else: ?>
		<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('job_listing_category') ); ?>" />
	<?php endif; ?>

	<?php if(get_option('workscout_enable_filter_salary')) : ?>
	<div class="widget widget_range_filter" style="margin-bottom: 10px">

		<h4 class="checkboxes" style="margin-bottom: 0;">
			<input type="checkbox"  name="filter_by_salary_check" id="salary_check" class="filter_by_check"> 
			<label for="salary_check"><?php esc_html_e('Filter by Salary','workscout'); ?></label>
		</h4>

		<div class="widget_range_filter-inside">
			<div class="salary_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_salary" id="salary_amount" type="checkbox"   >
			<div id="salary-range"></div>
			<div class="margin-bottom-50"></div>
		</div>

	</div>
	<?php endif; ?>

	<?php if(get_option('workscout_enable_filter_rate')) : ?>
	<div class="widget widget_range_filter">
		<h4 class="checkboxes" style="margin-bottom: 0;">
			<input type="checkbox" name="filter_by_rate_check" id="filter_by_rate" class="filter_by_check"> 
			<label for="filter_by_rate"><?php esc_html_e('Filter by Rate','workscout'); ?></label>
		</h4>
		<div class="widget_range_filter-inside">
			<div class="rate_amount range-indicator">
				<span class="from"></span> &mdash; <span class="to"></span>
			</div>
		    <input type="hidden" name="filter_by_rate" id="rate_amount" type="checkbox"  >
			<div id="rate-range"></div>
		</div>
	</div>
	<?php endif; ?>

</form>
	<?php dynamic_sidebar( 'sidebar-jobs' ); ?>
</div><!-- #secondary -->

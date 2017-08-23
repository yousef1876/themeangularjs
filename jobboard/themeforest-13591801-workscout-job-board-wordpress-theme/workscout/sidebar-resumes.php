<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<!-- Widgets -->
<div class="five columns sidebar "  role="complementary">
<form class="resume_filters in_sidebar">

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
	
	<!-- Skills -->
<?php if ( get_option( 'resume_manager_enable_skills' ) ) : ?>
	<?php
		if ( ! empty( $_GET['search_skills'] ) ) {
			$selected_skills = sanitize_text_field( $_GET['search_skills'] );
		} else {
			$selected_skills  = '';
		}
		if ( ! is_tax( 'resume_skill' ) && get_terms( 'resume_skill' ) ) : ?>
		<div class="widget">
			<h4><?php esc_html_e('Filter by Skills','workscout'); ?></h4>
			<div class="search_categories resume-filter">
				<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_skill', 'hierarchical' => 1, 'name' => 'search_skills', 'orderby' => 'name', 'selected' => $selected_skills, 'hide_empty' => false, 'class' => 'chosen-select', 'id'=>'search_skills', 'placeholder'=> esc_html__('Choose a skill','workscout') ) ); ?>
				
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

	
	<?php 
		if ( ! empty( $_GET['search_categories'] ) ) {
			$selected_category = sanitize_text_field( $_GET['search_categories'] );
		} else {
			$selected_category  = '';
		}

	if ( get_option( 'resume_manager_enable_categories' ) && ! is_tax( 'resume_category' ) && get_terms( 'resume_category' ) ) : ?>
		<div class="widget">
		<h4><?php esc_html_e('Filter by Categories','workscout'); ?></h4>
			<div class="search_categories resume-filter">
				<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'hide_empty' => false, 'id'=>'search_categories' ) ); ?>
			</div>
		</div>
	<?php else: ?>
		<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( get_query_var('resume_category') ); ?>" />
	<?php endif; ?>

	<?php if(get_option('workscout_enable_resume_filter_rate')) : ?>
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
	<?php dynamic_sidebar( 'sidebar-resumes' ); ?>
</div><!-- #secondary -->

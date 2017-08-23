<?php
/**
 * Template Name: Page with Jobs Search
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */

get_header(); ?>

<div id="banner" class="workscout-search-banner" >
    <div class="container">
        <div class="sixteen columns">
            
            <div class="search-container">

                <!-- Form -->
                <h2><?php esc_html_e('Find Job','workscout') ?></h2>
                <form method="GET" action="<?php echo get_permalink(get_option('job_manager_jobs_page_id')); ?>">
            
                    <input type="text" id="search_keywords" name="search_keywords"  class="ico-01" placeholder="<?php esc_attr_e('job title, keywords or company name','workscout'); ?>" value=""/>
                    <input type="text" id="search_location" name="search_location" class="ico-02" placeholder="<?php esc_attr_e('city, province or region','workscout'); ?>" value=""/>

                    <button><i class="fa fa-search"></i></button>

                </form>
                <!-- Browse Jobs -->
                <div class="browse-jobs">
                    <?php $categoriespage = ot_get_option('pp_categories_page'); 
                    if(!empty($categoriespage)) { 
                        printf( __( ' Or browse job offers by <a href="%s">category</a>', 'workscout' ), get_permalink($categoriespage) );
                    } ?>
                </div>
                
                <!-- Announce -->
                <div class="announce">
                    <?php $count_jobs = wp_count_posts( 'job_listing', 'readable' ); 
                    printf( esc_html__( 'We have %s job offers for you!', 'workscout' ), '<strong>' . $count_jobs->publish . '</strong>' ) ?>
                </div>

            </div>

        </div>
    </div>
</div>

<?php
while ( have_posts() ) : the_post(); ?>
<!-- 960 Container -->
<div class="container page-container home-page-container">
    <article <?php post_class("sixteen columns"); ?>>
                <?php the_content(); ?>
    </article>
</div>
<?php endwhile; // end of the loop.

get_footer(); ?>
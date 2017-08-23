<?php 

/**
* Clear shortcode
* Usage: [clear]
*/
if (!function_exists('pp_clear')) {
    function pp_clear() {
        return '<div class="clear"></div>';
    }
    add_shortcode( 'clear', 'pp_clear' );
}

/**
* Icon shortcode
* Usage: [icon icon="icon-exclamation"]
*/
function pp_icon($atts) {
    extract(shortcode_atts(array(
        'icon'=>''), $atts));
    return '<i class="fa fa-'.$icon.'"></i>';
}
add_shortcode('icon', 'pp_icon');
/**
* Spacer shortcode
* Usage: [space]
*/
if (!function_exists('pp_spacer')) {
    function pp_spacer($atts, $content ) {
        extract(shortcode_atts(array(
            'class' => ''
            ), $atts));
        return '<div class="clearfix"></div><div class="'.$class.'"></div>';
    }
    add_shortcode( 'space', 'pp_spacer' );
    add_shortcode( 'spacer', 'pp_spacer' );
}


/**
* Highlight shortcode
* Usage: [highlight style="gray"] [/highlight] // color, gray, light
*/
function pp_highlight($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => 'gray'
        ), $atts));
    return '<span class="highlight '.$style.'">'.$content.'</span>';
}
add_shortcode('highlight', 'pp_highlight');



function pp_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => '#',
        "color" => 'color',  //gray color dark
        "customcolor" => '',
        "iconcolor" => 'white',
        "icon" => '',
        "target" => '',
        "customclass" => '',
        "from_vs" => 'no',
        ), $atts));
    if($from_vs == 'yes') {
        $link = vc_build_link( $url );
        $a_href = $link['url'];
        $a_title = $link['title'];
        $a_target = $link['target'];
        $output = '<a class="button '.$color.' '.$customclass.'" href="'.$a_href.'" title="'.esc_attr( $a_title ).'" target="'.$a_target.'"';
        if(!empty($customcolor)) { $output .= 'style="background-color:'.$customcolor.'"'; }
        $output .= '>';
        if(!empty($icon)) { $output .= '<i class="fa fa-'.$icon.'  '.$iconcolor.'"></i> '; }
        $output .= $a_title.'</a>';
    } else {
        $output = '<a class="button '.$color.' '.$customclass.'" href="'.$url.'" ';
        if(!empty($target)) { $output .= 'target="'.$target.'"'; }
        if(!empty($customcolor)) { $output .= 'style="background-color:'.$customcolor.'"'; }
        $output .= '>';
        if(!empty($icon)) { $output .= '<i class="fa fa-'.$icon.'  '.$iconcolor.'"></i> '; }
        $output .= $content.'</a>';
    }
    return $output;
}
add_shortcode('button', 'pp_button');



/**
* Dropcap shortcode type = full
* Usage: [dropcap color="gray"] [/dropcap]// margin-down margin-both
*/
if (!function_exists('pp_dropcap')) {
    function pp_dropcap($atts, $content = null) {
        extract(shortcode_atts(array(
            'type'=>''), $atts));
        return '<span class="dropcap '.$type.'">'.$content.'</span>';
    }
    add_shortcode('dropcap', 'pp_dropcap');
}


if (!function_exists('pp_popup')) {
    function pp_popup($atts, $content = null) {
        extract(shortcode_atts(array(
            'buttontext'=>' Open Popup',
            'title'=>' Modal popup',
            ), $atts));
         $randID = rand(1, 99);
  $output = '
        <a class="popup-with-zoom-anim button color" href="#small-dialog'.$randID.'" ><i class="fa fa-info-circle"></i> '.$buttontext.'</a><br/>
            <div id="small-dialog'.$randID.'" class="small-dialog zoom-anim-dialog mfp-hide">
                <h2 class="margin-bottom-10">'.$title.'</h2>
                <p class="margin-reset">'.do_shortcode( $content ).'</p>
            </div>';
    return $output;
    }
    add_shortcode('popup', 'pp_popup');
}

/**
* List style shortcode
* Usage: [list type="check"] [/list] // check, arrow, checkbg, arrowbg
*/
function pp_liststyle($atts, $content = null) {
    extract(shortcode_atts(array(
        "style" => '1',
        "color" => 'no'
        ), $atts));
    if($color=='yes') { $class="color"; } else { $class = ' '; };
    $output = '<div class="list-'.$style.' '.$class.'">'.$content.'</div>';
    return $output;
}

add_shortcode('list', 'pp_liststyle');


/*
    Shortcode prints grid of categories with icon boxes
    Usage: [box_job_categories orderby="count" order="ASC" number]
*/
add_shortcode('box_job_categories', 'workscout_job_categories');

function workscout_job_categories( $atts ) {
    extract(shortcode_atts(array(
        'hide_empty'        => 0,
        'orderby'           => 'count',
        'order'             => 'DESC',
        'number'            => '8',
        'browse_link'       => '',
        'include'           => '',
        'exclude'           => '',
        'child_of'          => 0,

        ), $atts));
    $include         = is_array( $include ) ? $include : array_filter( array_map( 'trim', explode( ',', $include ) ) );
    $exclude         = is_array( $exclude ) ? $exclude : array_filter( array_map( 'trim', explode( ',', $exclude ) ) );

    $output = '<ul id="popular-categories">';


    $categories = get_terms( 'job_listing_category', array(
        'orderby'       => $orderby, // id count name - Default slug term_group - Not fully implemented (avoid using) none
        'order'         => $order, // id count name - Default slug term_group - Not fully implemented (avoid using) none
        'hide_empty'    => $hide_empty,
        'number'        => $number,
        'include'       => $include,
        'exclude'       => $exclude,
        'child_of'      => $child_of,
     ) );
    
    if ( !is_wp_error( $categories ) ) {
    
      foreach ($categories  as $term ) {
        $t_id = $term->term_id;
        $term_meta = get_option( "taxonomy_$t_id" ); 
        $icon = $term_meta['fa_icon'];
        $imageicon = $term_meta['upload_icon'];
        $output .= ' 
        <li>
            <a href="' . get_term_link( $term ) . '">';
            if(!empty($icon)) {  
                $output .= ' <i class="fa fa-'.esc_attr($icon).'"></i>'; 
            } elseif (!empty($imageicon)) {
                $output .= '<img src="'.esc_attr($imageicon).'"/>';
            } 
            
            $output .=  $term->name .'</a>
        </li>';
      }
    }  
    if  (is_wp_error( $categories )) {
        $output .= '<li>Please enable  categories for listings in wp-admin > Job Listings -> Settings and add some categories</li>';

    }
    $output .= '</ul><div class="clearfix"></div>
        <div class="margin-top-30"></div>';
        if($browse_link) {

        $output .= '<a href="'.esc_url( get_permalink(ot_get_option('pp_categories_page')) ).'" class="button centered">'.esc_html__('Browse All Categories','workscout').'</a>
            <div class="margin-bottom-50"></div>';
        }
    return $output;
}


/**
* Headline shortcode
* Usage: [headline ] [/headline] // margin-down margin-both
*/
function pp_headline( $atts, $content ) {
  extract(shortcode_atts(array(
    'margintop' => 0,
    'marginbottom' => 25,
    'clearfix' => 0,
    'type' => 'h3'
    ), $atts));
  $output = '<'.$type.' class="margin-top-'.$margintop.' margin-bottom-'.$marginbottom.'">'.do_shortcode( $content ).'</'.$type.'>';
    if($clearfix == 1) {   $output .= '<div class="clearfix"></div>';}
    return $output;
}
add_shortcode( 'headline', 'pp_headline' );



/**
* Headline shortcode
* Usage: [jobs]
* Hacks the default jobs shortcode from wp-job-manager and allows better filtering
*/

add_shortcode('jobs', 'workscout_output_jobs');
function workscout_output_jobs( $atts ) {
    ob_start();
    wp_enqueue_script( 'workscout-wp-job-manager-ajax-filters' );
    extract( $atts = shortcode_atts( apply_filters( 'job_manager_output_jobs_defaults', array(
        'per_page'                  => get_option( 'job_manager_per_page' ),
        'orderby'                   => 'featured',
        'order'                     => 'DESC',


        // Filters + cats
        'show_filters'              => true,
        'show_categories'           => true,
        'show_category_multiselect' => get_option( 'job_manager_enable_default_category_multiselect', false ),
        'show_pagination'           => false,
        'show_more'                 => true,
        'show_description'           => true,

        // Limit what jobs are shown based on category and type
        'categories'                => '',
        'job_types'                 => '',
        'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
        'filled'                    => null, // True to show only filled, false to hide filled, leave null to show both/use the settings.

        // Default values for filters
        'location'                  => '',
        'keywords'                  => '',
        'selected_category'         => '',
        'selected_job_types'        => implode( ',', array_values( get_job_listing_types( 'id=>slug' ) ) ),
    ) ), $atts ) );

    if ( ! get_option( 'job_manager_enable_categories' ) ) {
        $show_categories = false;
    }

    // String and bool handling
    $show_filters              = workscout_string_to_bool( $show_filters );
    $show_categories           = workscout_string_to_bool( $show_categories );
    $show_category_multiselect = workscout_string_to_bool( $show_category_multiselect );
    $show_more                 = workscout_string_to_bool( $show_more );
    $show_pagination           = workscout_string_to_bool( $show_pagination );
    $show_description           = workscout_string_to_bool( $show_description );

    if ( ! is_null( $featured ) ) {
        $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
    }

    if ( ! is_null( $filled ) ) {
        $filled = ( is_bool( $filled ) && $filled ) || in_array( $filled, array( '1', 'true', 'yes' ) ) ? true : false;
    }

    // Array handling
    $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
    $job_types          = is_array( $job_types ) ? $job_types : array_filter( array_map( 'trim', explode( ',', $job_types ) ) );
    $selected_job_types = is_array( $selected_job_types ) ? $selected_job_types : array_filter( array_map( 'trim', explode( ',', $selected_job_types ) ) );

    // Get keywords and location from querystring if set
    if ( ! empty( $_GET['search_keywords'] ) ) {
        $keywords = sanitize_text_field( $_GET['search_keywords'] );
    }
    if ( ! empty( $_GET['search_location'] ) ) {
        $location = sanitize_text_field( $_GET['search_location'] );
    }
    if ( ! empty( $_GET['search_category'] ) ) {
        $selected_category = sanitize_text_field( $_GET['search_category'] );
    }

    if ( $show_filters ) {

        get_job_manager_template( 'job-filters.php', array( 'per_page' => $per_page, 'orderby' => $orderby, 'order' => $order, 'show_categories' => $show_categories, 'categories' => $categories, 'selected_category' => $selected_category, 'job_types' => $job_types, 'atts' => $atts, 'location' => $location, 'keywords' => $keywords, 'selected_job_types' => $selected_job_types, 'show_category_multiselect' => $show_category_multiselect ) );

        get_job_manager_template( 'job-listings-start.php' );
        get_job_manager_template( 'job-listings-end.php' );

        if ( ! $show_pagination && $show_more ) {
            echo '<a class="load_more_jobs" href="#" style="display:none;"><strong>' . esc_html__( 'Load more listings', 'workscout' ) . '</strong></a>';
        }

    } else {

        $jobs = get_job_listings( apply_filters( 'job_manager_output_jobs_args', array(
            'search_location'   => $location,
            'search_keywords'   => $keywords,
            'search_categories' => $categories,
            'job_types'         => $job_types,
            'orderby'           => $orderby,
            'order'             => $order,
            'posts_per_page'    => $per_page,
            'featured'          => $featured,
            'filled'            => $filled
        ) ) );

        if ( $jobs->have_posts() ) : ?>

            <!-- Listings Loader -->
            <div class="listings-loader">
                <i class="fa fa-spinner fa-pulse"></i>
            </div>

            <ul class="job_listings job-list full <?php if(!$show_description){ echo "hide-desc";} ?>">

            <?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
                <?php get_job_manager_template_part( 'content', 'job_listing' ); ?>
            <?php endwhile; ?>

            <?php get_job_manager_template( 'job-listings-end.php' ); ?>

            <?php if ( $jobs->found_posts > $per_page && $show_more ) : ?>

                <?php wp_enqueue_script( 'wp-job-manager-ajax-filters' ); ?>

                <?php if ( $show_pagination ) : ?>
                    <?php echo get_job_listing_pagination( $jobs->max_num_pages ); ?>
                <?php else : ?>
                    <a class="load_more_jobs button centered" href="#"><i class="fa fa-plus-circle"></i><?php esc_html_e( 'Show More Jobs', 'workscout' ); ?></a>
                    <div class="margin-bottom-55"></div>
                <?php endif; ?>

            <?php endif; ?>

        <?php else :
            ?> <ul class="job_listings job-list full <?php if(!$show_description){ echo "hide-desc";} ?>"> <?php 
            do_action( 'job_manager_output_jobs_no_results' );
            ?> </ul> <?php
        endif;

        wp_reset_postdata();
    }

    $data_attributes_string = '';
    $data_attributes        = array(
        'location'        => $location,
        'keywords'        => $keywords,
        'show_filters'    => $show_filters ? 'true' : 'false',
        'show_pagination' => $show_pagination ? 'true' : 'false',
        'per_page'        => $per_page,
        'orderby'         => $orderby,
        'order'           => $order,
        'categories'      => implode( ',', $categories ),
    );
    if ( ! is_null( $featured ) ) {
        $data_attributes[ 'featured' ] = $featured ? 'true' : 'false';
    }
    if ( ! is_null( $filled ) ) {
        $data_attributes[ 'filled' ]   = $filled ? 'true' : 'false';
    }
    foreach ( $data_attributes as $key => $value ) {
        $data_attributes_string .= 'data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
    }

    $job_listings_output = apply_filters( 'job_manager_job_listings_output', ob_get_clean() );

    return '<div class="job_listings" ' . $data_attributes_string . '>' . $job_listings_output . '</div>';
}


add_shortcode('resumes', 'workscout_output_resumes');
function workscout_output_resumes( $atts ) {
    global $resume_manager;

        ob_start();
        wp_enqueue_script( 'workscout-wp-resume-manager-ajax-filters' );
        if ( ! resume_manager_user_can_browse_resumes() ) {
            get_job_manager_template_part( 'access-denied', 'browse-resumes', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            return ob_get_clean();
        }

        extract( $atts = shortcode_atts( apply_filters( 'resume_manager_output_resumes_defaults', array(
            'per_page'                  => get_option( 'resume_manager_per_page' ),
            'order'                     => 'DESC',
            'orderby'                   => 'featured',
            'show_filters'              => true,
            'show_categories'           => get_option( 'resume_manager_enable_categories' ),
            'categories'                => '',
            'featured'                  => null, // True to show only featured, false to hide featured, leave null to show both.
            'show_category_multiselect' => get_option( 'resume_manager_enable_default_category_multiselect', false ),
            'selected_category'         => '',
            'show_pagination'           => false,
            'show_more'                 => true,
        ) ), $atts ) );

        $categories = array_filter( array_map( 'trim', explode( ',', $categories ) ) );
        $keywords   = '';
        $location   = '';

        // String and bool handling
        $show_filters              = workscout_string_to_bool( $show_filters );
        $show_categories           = workscout_string_to_bool( $show_categories );
        $show_category_multiselect = workscout_string_to_bool( $show_category_multiselect );
        $show_more                 = workscout_string_to_bool( $show_more );
        $show_pagination           = workscout_string_to_bool( $show_pagination );

        if ( ! is_null( $featured ) ) {
            $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
        }

        if ( ! empty( $_GET['search_keywords'] ) ) {
            $keywords = sanitize_text_field( $_GET['search_keywords'] );
        }

        if ( ! empty( $_GET['search_location'] ) ) {
            $location = sanitize_text_field( $_GET['search_location'] );
        }

        if ( ! empty( $_GET['search_category'] ) ) {
            $selected_category = sanitize_text_field( $_GET['search_category'] );
        }

        if ( $show_filters ) {

            get_job_manager_template( 'resume-filters.php', array( 'per_page' => $per_page, 'orderby' => $orderby, 'order' => $order, 'show_categories' => $show_categories, 'categories' => $categories, 'selected_category' => $selected_category, 'atts' => $atts, 'location' => $location, 'keywords' => $keywords, 'show_category_multiselect' => $show_category_multiselect ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

            get_job_manager_template( 'resumes-start.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            get_job_manager_template( 'resumes-end.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

            if ( ! $show_pagination && $show_more ) {
                echo '<a class="load_more_resumes" href="#" style="display:none;"><strong>' . __( 'Load more resumes', 'wp-job-manager-resumes' ) . '</strong></a>';
            }

        } else {

            $resumes = get_resumes( apply_filters( 'resume_manager_output_resumes_args', array(
                'search_categories' => $categories,
                'orderby'           => $orderby,
                'order'             => $order,
                'categories'        => $categories,
                'search_keywords'   => $keywords,
                'search_location'   => $location,
                'posts_per_page'    => $per_page,
                'featured'          => $featured
            ) ) );

            if ( $resumes->have_posts() ) : ?>

                <?php get_job_manager_template( 'resumes-start.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

                <?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>
                    <?php get_job_manager_template_part( 'content', 'resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
                <?php endwhile; ?>

                <?php get_job_manager_template( 'resumes-end.php', array(), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

                <?php if ( $resumes->found_posts > $per_page && $show_more ) : ?>

                    <?php wp_enqueue_script( 'wp-resume-manager-ajax-filters' ); ?>

                    <?php if ( $show_pagination ) : ?>
                        <?php echo get_job_listing_pagination( $resumes->max_num_pages ); ?>
                    <?php else : ?>
                        <a class="load_more_resumes" href="#"><strong><?php _e( 'Load more resumes', 'wp-job-manager-resumes' ); ?></strong></a>
                    <?php endif; ?>

                <?php endif; ?>

            <?php else :
                do_action( 'resume_manager_output_resumes_no_results' );
            endif;

            wp_reset_postdata();
        }

        $data_attributes_string = '';
        $data_attributes        = array(
            'location'        => $location,
            'keywords'        => $keywords,
            'show_filters'    => $show_filters ? 'true' : 'false',
            'show_pagination' => $show_pagination ? 'true' : 'false',
            'per_page'        => $per_page,
            'orderby'         => $orderby,
            'order'           => $order,
            'categories'      => implode( ',', $categories )
        );
        if ( ! is_null( $featured ) ) {
            $data_attributes[ 'featured' ] = $featured ? 'true' : 'false';
        }
        foreach ( $data_attributes as $key => $value ) {
            $data_attributes_string .= 'data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
        }

        return '<div class="resumes" ' . $data_attributes_string . '>' . ob_get_clean() . '</div>';
}


/**
* Spotlight shortcode
* Usage: [spotlight_jobs]
* Shows selected jobs in carousel
*/

add_shortcode('spotlight_jobs', 'workscout_featured_jobs');
function workscout_featured_jobs( $atts ) {
    ob_start();

    extract( $atts = shortcode_atts( apply_filters( 'job_manager_output_jobs_defaults', array(
        'per_page'                  => get_option( 'job_manager_per_page' ),
        'orderby'                   => 'featured',
        'order'                     => 'DESC',
        'title'                     => 'Job Spotlight',
        'visible'                   => '1,1,1,1',
        
        // Limit what jobs are shown based on category and type
        'categories'                => '',
        'job_types'                 => '',
        'featured'                  => true, // True to show only featured, false to hide featured, leave null to show both.
        'filled'                    => null, // True to show only filled, false to hide filled, leave null to show both/use the settings.

        
    ) ), $atts ) );

    $randID = rand(1, 99); 

    if ( ! is_null( $filled ) ) {
        $filled = ( is_bool( $filled ) && $filled ) || in_array( $filled, array( '1', 'true', 'yes' ) ) ? true : false;
    }

    // Array handling
    $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
    $job_types          = is_array( $job_types ) ? $job_types : array_filter( array_map( 'trim', explode( ',', $job_types ) ) );
    if ( ! is_null( $featured ) ) {
        $featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
    }

    $jobs = get_job_listings(  array(
            'search_categories' => $categories,
            'job_types'         => $job_types,
            'orderby'           => $orderby,
            'order'             => $order,
            'posts_per_page'    => $per_page,
            'featured'          => $featured,
            'filled'            => $filled
        )  );
   
   if ( $jobs->have_posts() ) : ?>
 
        <h3 class="margin-bottom-5"><?php echo esc_html($title); ?></h3>
        <!-- Navigation -->
        <div class="showbiz-navigation">
            <div id="showbiz_left_<?php echo esc_attr($randID); ?>" class="sb-navigation-left"><i class="fa fa-angle-left"></i></div>
            <div id="showbiz_right_<?php echo esc_attr($randID); ?>" class="sb-navigation-right"><i class="fa fa-angle-right"></i></div>
        </div>
        <div class="clearfix"></div>
        
        <!-- Showbiz Container -->
        <div id="job-spotlight" class="job-spotlight-car showbiz-container" data-visible="[<?php echo $visible; ?>]">
            <div class="showbiz" data-left="#showbiz_left_<?php echo esc_attr($randID); ?>" data-right="#showbiz_right_<?php echo esc_attr($randID); ?>" data-play="#showbiz_play_<?php echo esc_attr($randID); ?>" >
                <div class="overflowholder">
                    <ul>
                      <?php while ( $jobs->have_posts() ) : $jobs->the_post();
                        $id = get_the_id(); ?>
                        <li>
                            <div class="job-spotlight">
                                <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?> <span class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>"><?php the_job_type(); ?></span></h4></a>
                                <span><i class="fa fa-briefcase"></i> <?php the_company_name(  ); ?></span>
                                <span><i class="fa fa-map-marker"></i> <?php the_job_location(); ?></span>
                                
                                <?php 
                                $rate_min = get_post_meta( $id, '_rate_min', true ); 
                                if ( $rate_min) { 
                                    $rate_max = get_post_meta( $id, '_rate_max', true );  ?>
                                    <span>
                                        <i class="fa fa-money"></i> <?php  echo get_workscout_currency_symbol();  echo esc_html( $rate_min ); if(!empty($rate_max)) { echo '- '.$rate_max; } ?> / hour
                                    </span>
                                <?php } ?>

                                <?php 
                                $salary_min = get_post_meta( $id, '_salary_min', true ); 
                                if ( $salary_min ) {
                                    $salary_max = get_post_meta( $id, '_salary_max', true );  ?>
                                    <span>
                                        <i class="fa fa-money"></i>
                                        <?php echo get_workscout_currency_symbol(); echo esc_html( $salary_min ) ?> <?php if(!empty($salary_max)) { echo '- '.$salary_max; } ?>
                                    </span>
                                <?php } ?>
                                
                                <p><?php  
                                    $excerpt = get_the_excerpt();
                                    echo workscout_string_limit_words($excerpt,20); ?>...
                                </p>
                                <a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e('Apply For This Job','workscout') ?></a>
                            </div>
                        </li>
                        <?php endwhile; ?>
                        
                    </ul>
                    <div class="clearfix"></div>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php  
    endif; 
    $job_listings_output =  ob_get_clean();

    return $job_listings_output;

}


/**
* Testimonials shortcode
* Usage: [testimonials_wide]
* Shows selected jobs in carousel
*/
add_shortcode('testimonials_wide','workscout_full_testimonials');
function workscout_full_testimonials($atts) { 
    extract(shortcode_atts(array(
        'per_page'                  =>'4',
        'orderby'                   => 'date',
        'order'                     => 'DESC',
        'exclude_posts'             => '',
        'include_posts'             => '',
        'background'                => '',
        'from_vs'                   => '',
        ), $atts));

    $randID = rand(1, 99);

    $args = array(
        'post_type' => array('testimonial'),
        'showposts' => $per_page,
        'orderby' => $orderby,
        'order' => $order,
    );
    if(!empty($exclude_posts)) {
        $exl = explode(",", $exclude_posts);
        $args['post__not_in'] = $exl;
    }
    if(!empty($include_posts)) {
        $inc = explode(",", $include_posts);
        $args['post__in'] = $inc;
    }
    $wp_query = new WP_Query( $args );
   
    if($from_vs === 'yes') {
        $bg_url = wp_get_attachment_url( $background );
    } else {
        $bg_url = $background;
    }
    if($from_vs === 'yes') {
        $output = '</div> <!-- eof wpb_wrapper -->
                </div> <!-- eof column_container -->
            </div> <!-- eof vc_row-fluid -->
        </article> <!-- eof columns -->
    </div> <!-- eof container -->';
    } else {
         $output = '</article>
        </div>';
    }
   
    $output .= '<!-- Testimonials -->
    <div id="testimonials" style="background-image: url('.$bg_url.');">
        <!-- Slider -->
        <div class="container">
            <div class="sixteen columns">
                <div class="testimonials-slider">
                      <ul class="slides">';
                if ( $wp_query->have_posts() ):
                        while( $wp_query->have_posts() ) : $wp_query->the_post(); 
                        $id = $wp_query->post->ID;
                        $author = get_post_meta($id, 'pp_author', true);
                        $link = get_post_meta($id, 'pp_link', true);
                        $position = get_post_meta($id, 'pp_position', true);
                        
                        $output .= '<li>
                          <p>'.get_the_content().'
                          <span>'.get_the_title($id);
                             if(!empty($position)){
                                $output .= ', '.$position;
                                } 
                          $output .= '</span></p>
                        </li>';

                        endwhile;  // close the Loop
                endif;
                $output .='
                      </ul>
                </div>
            </div>
        </div>
    </div>';
    if($from_vs === 'yes') {
    $output .= '
    <div class="container">
        <article class="sixteen columns">
             <div class="vc_row wpb_row vc_row-fluid">
                <div class="vc_col-sm-12 wpb_column column_container">
                    <div class="wpb_wrapper">';
    } else {
        $output .= ' <div class="container">
            <article class="sixteen columns">';
    }
    
    return $output;
}

/**
* Actionbox shortcode
* Usage: [actionbox]
* Shows actionbox
*/
add_shortcode('actionbox','workscout_actionbox');
function workscout_actionbox($atts, $content ) { 
    extract(shortcode_atts(array(
        'wide'                      => 'true',
        'title'                   => 'Start Building Your Own Job Board Now ',
        'url'                     => '#',
        'buttontext'             => '',
        'from_vs'                   => '',
        ), $atts));
    $output = '';

    if($wide=='true') {
        if($from_vs === 'yes') {
            $output = '</div> <!-- eof wpb_wrapper -->
                    </div> <!-- eof column_container -->
                </div> <!-- eof vc_row-fluid -->
            </article> <!-- eof columns -->
        </div> <!-- eof container -->';
        } else {
             $output = '</article>
            </div>';
        }
        $output .='         
        <!-- Infobox -->
        <div class="infobox">
            <div class="container">
                <div class="sixteen columns">
                '.$title;
                   if(!empty($buttontext)) { $output .=' <a href="'.$url.'">'.$buttontext.'</a>'; }
                $output .='</div>
            </div>
        </div>';
        if($from_vs === 'yes') {
        $output .= '
        <div class="container">
            <article class="sixteen columns">
                 <div class="vc_row wpb_row vc_row-fluid">
                    <div class="vc_col-sm-12 wpb_column column_container">
                        <div class="wpb_wrapper">';
        } else {
            $output .= ' <div class="container">
                <article class="sixteen columns">';
        }
       
    } else {
        $output .='
            <div class="infobox">
                '.$title;
                if(!empty($buttontext)) { $output .='<a href="'.$url.'">'.$buttontext.'</a>'; }
        $output .='</div>';
    }

 return $output;
}


add_shortcode('centered_headline','workscout_centered_headline');
function workscout_centered_headline($atts, $content ) { 
    extract(shortcode_atts(array(
        'wide'                      => 'true',
        'title'                     => 'Start Building Your Own Job Board Now ',
        'url'                       => '#',
        'subtitle'                  => '',
        'from_vs'                   => '',
        ), $atts));
    $output = '';

    if($wide=='true') {
        if($from_vs === 'yes') {
            $output = '</div> <!-- eof wpb_wrapper -->
                    </div> <!-- eof column_container -->
                </div> <!-- eof vc_row-fluid -->
            </article> <!-- eof columns -->
        </div> <!-- eof container -->';
        } else {
             $output = '</article>
            </div>';
        }
        $output .='<!-- Infobox -->
               <h3 class="centered-headline">'.$title;
                   if(!empty($url)) { 
                        $output .=' <a href="'.$url.'"><span>'.$subtitle.'</span></a>'; 
                    } else {
                        $output .=' <span>'.$subtitle.'</span>'; 
                    }
        $output .='</h3>';
        if($from_vs === 'yes') {
            $output .= '
            <div class="container">
                <article class="sixteen columns">
                    <div class="vc_row wpb_row vc_row-fluid">
                        <div class="vc_col-sm-12 wpb_column column_container">
                            <div class="wpb_wrapper">';
        } else {
            $output .= ' <div class="container">
                <article class="sixteen columns">';
        }
       
    } else {
        $output .='
            <h3 class="centered-headline">'.$title;
                   if(!empty($url)) { 
                        $output .=' <a href="'.$url.'"><span>'.$subtitle.'</span></a>'; 
                    } else {
                        $output .=' <span>'.$subtitle.'</span>'; 
                    }
        $output .='</h3>';
    }

 return $output;
}



/**
* Recent work shortcode
* Usage: [clients_carousel title="Recent Work" ] [/clients_carousel]
*/
function pp_clients_carousel($atts, $content ) {
    extract(shortcode_atts(array(
        'width' => 'sixteen',
        'place' => 'center'
        ), $atts));

    $output = '';
    $width_arr = array(
        'sixteen' => 16, 'fifteen' => 15, 'fourteen' => 14, 'thirteen' => 13, 'twelve' => 12, 'eleven' => 11, 'ten' => 10, 'nine' => 9,
        'eight' => 8, 'seven' => 7, 'six' => 6, 'five' => 5, 'four' => 4, 'three' => 3
        );
    $randID = rand(1, 99); // Get unique ID for carousel
    if(empty($width)) { $width = "sixteen"; }

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }

    $carousel_width = $width_arr[$width] - 2;
    $carousel_key_width = array_search ($carousel_width, $width_arr);
    $output .= '
    <!-- Navigation / Left -->
    <div class="one carousel column alpha"><div id="showbiz_left_'.$randID.'" class="sb-navigation-left-2"><i class="fa fa-angle-left"></i></div></div>

    <!-- ShowBiz Carousel -->
    <div id="our-clients" class="our-clients-run showbiz-container '.$carousel_key_width.' carousel columns" >

    <!-- Portfolio Entries -->
    <div class="showbiz our-clients" data-left="#showbiz_left_'.$randID.'" data-right="#showbiz_right_'.$randID.'">
        <div class="overflowholder">';
            $output .= do_shortcode( $content );
            $output .='<div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
    <!-- Navigation / Right -->
    <div class="one carousel column omega"><div id="showbiz_right_'.$randID.'" class="sb-navigation-right-2"><i class="fa fa-angle-right"></i></div></div>';
    return $output;
}
add_shortcode('clients_carousel', 'pp_clients_carousel');

/**
* Columns shortcode
* Usage: [column width="eight" place="" custom_class=""] [/column]
*/

function pp_column($atts, $content = null) {
    extract( shortcode_atts( array(
        'width' => 'eight',
        'place' => '',
        'custom_class' => ''
        ), $atts ) );

    switch ( $width ) {
        case "1/3" : $w = "column one-third"; break;
        case "one-third" : $w = "column one-third"; break;

        case "2/3" :
        $w = "column two-thirds";
        break;

        case "one" : $w = "one columns"; break;
        case "two" : $w = "two columns"; break;
        case "three" : $w = "three columns"; break;
        case "four" : $w = "four columns"; break;
        case "five" : $w = "five columns"; break;
        case "six" : $w = "six columns"; break;
        case "seven" : $w = "seven columns"; break;
        case "eight" : $w = "eight columns"; break;
        case "nine" : $w = "nine columns"; break;
        case "ten" : $w = "ten columns"; break;
        case "eleven" : $w = "eleven columns"; break;
        case "twelve" : $w = "twelve columns"; break;
        case "thirteen" : $w = "thirteen columns"; break;
        case "fourteen" : $w = "fourteen columns"; break;
        case "fifteen" : $w = "fifteen columns"; break;
        case "sixteen" : $w = "sixteen columns"; break;

        default :
        $w = 'columns eight';
    }

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }

    $column ='<div class="'.$w.' '.$custom_class.' '.$p.'">'.do_shortcode( $content ).'</div>';
    if($place=='last') {
        $column .= '<br class="clear" />';
    }
    return $column;
}

add_shortcode('column', 'pp_column');



/**
* Recent work shortcode
* Usage: [recent_blog limit="4" title="Recent Work" orderby="date" order="DESC"  carousel="yes"] [/recent_blog]
*/
add_shortcode('latest_from_blog', 'workscout_recent_blog');
function workscout_recent_blog($atts, $content ) {
    extract(shortcode_atts(array(
        'limit'=>'3',
        'columns' => '3',
        'orderby'=> 'date',
        'order'=> 'DESC',
        'categories' => '',
        'masonry' => '',
        'tags' => '',
        'show_author' => '',
        'show_date' => '',
        'width' => 'sixteen',
        'place' => 'center',
        'exclude_posts' => '',
        'ignore_sticky_posts' => 1,
        'limit_words' => 15,
        'from_vs' => 'no'
        ), $atts));

    $output = '';
    $randID = rand(1, 99); // Get unique ID for carousel

    if(empty($width)) { $width = "sixteen"; } //set width to 16 even if empty value

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }
    
    wp_reset_postdata();

    if($masonry == 'yes') {
        $output.= '<div class="recent-blog-posts masonry">';
    } else {
        $output.= '<div class="recent-blog-posts">';
    }
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'orderby' => $orderby,
        'order' => $order,
        );
    if(!empty($exclude_posts)) {
        $exl = is_array( $exclude_posts ) ? $exclude_posts : array_filter( array_map( 'trim', explode( ',', $exclude_posts ) ) );
        $args['post__not_in'] = $exl;
    }

    if(!empty($categories)) {
        $categories         = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );
        $args['category__and'] = $categories;
    }
    if(!empty($tags)) {
        $tags         = is_array( $tags ) ? $tags : array_filter( array_map( 'trim', explode( ',', $tags ) ) );
        $args['tag__in'] = $tags;
    }
    $i = 0;
    $wp_query = new WP_Query( $args );
    if($from_vs === 'yes'){
        switch ($columns) {
            case '2':
                $mainclass = "vc_col-sm-6 wpb_column";
                break;
            case '3':
                $mainclass = "vc_col-sm-4 wpb_column";
                break;
            case '4':
                $mainclass = "vc_col-sm-3 wpb_column";
                break;
            default:
                # code...
                break;
        }
    } else {
        switch ($columns) {
            case '2':
                $mainclass = "eight columns recent-blog";
                break;
            case '3':
                $mainclass = "one-third columns recent-blog";
                break;
            case '4':
                $mainclass = "four columns recent-blog";
                break;
            default:
                # code...
                break;
        }
    }
    if ( $wp_query->have_posts() ):
        while( $wp_query->have_posts() ) : $wp_query->the_post();
            $i++;
            $id = $wp_query->post->ID;
            if($masonry != 'yes') {
                if($i == 1 || ($i % $columns) === 1) {
                    $colclass = 'alpha';
                } elseif ($i == $columns || ($i % $columns) === 0 ) {
                    $colclass = 'omega';
                } else {
                    $colclass= '';
                }
            } else {
                $colclass= '';
            }

            $thumb = get_post_thumbnail_id();
            $img_url = wp_get_attachment_url();

            $author_id = $wp_query->post->post_author;

            $output .= '
                <div class="'.$mainclass.' '.$colclass.'">
                    <article class="recent-post">';
                    $format = get_post_format();
                    if( false === $format )  $format = 'standard';

                    if($format == 'standard' && has_post_thumbnail()){
                        $output .= '
                        <figure class="recent-post-img">
                            <a href="'.get_permalink().'">'.get_the_post_thumbnail($id,'workscout-small-blog').'</a>
                            <div class="hover-icon"></div>
                        </figure>
                        ';
                    }

                    if($format == 'gallery') {
                        $gallery = get_post_meta($id, '_format_gallery', TRUE);
                        preg_match( '/ids=\'(.*?)\'/', $gallery, $matches );
                        if ( isset( $matches[1] ) ) {
                            // Found the IDs in the shortcode
                            $ids = explode( ',', $matches[1] );
                        } else {
                            // The string is only IDs
                            $ids = ! empty( $gallery ) && $gallery != '' ? explode( ',', $gallery ) : array();
                        }
                        $output .= '<div class="basic-slider royalSlider rsDefault">';
                        foreach ($ids as $imageid) {
                            $image_link = wp_get_attachment_url( $imageid );
                            if ( ! $image_link )
                                continue;
                                $image          = wp_get_attachment_image_src( $imageid, 'large');
                                $imageRSthumb   = wp_get_attachment_image_src( $imageid, $imagesize );
                                $image_title    = esc_attr( get_the_title( $imageid ) );
                                $output .= '<a href="'.$image[0].'" class="mfp-gallery"  title="'.esc_attr($image_title).'"><img class="rsImg" src="'.$imageRSthumb[0].'"  data-rsTmb="'.$imageRSthumb[0].'" /></a>';
                            }
                        $output .= '</div>';
                    }

                    if($format == 'quote') {
                        $output .= '<figure class="post-quote">
                            <span class="icon"></span>
                            <blockquote>
                              '.get_post_meta($id, '_format_quote_content', TRUE).'
                              <a href="'.esc_url(get_post_meta($id, '_format_quote_source_url', TRUE)).'"><span>- '.get_post_meta($id, '_format_quote_source_name', TRUE).'</span></a>
                            </blockquote>
                      </figure>';
                    } // eof gallery


                    if($format == 'video') {
                        $video = get_post_meta($id, '_format_video_embed', true);
                        if(!empty($video)) {
                            $output .= '<div class="embed">';
                                if(wp_oembed_get($video)) { $output .= wp_oembed_get($video); } else { $output .= $video;}
                            $output .= '</div>';
                        }
                    } // eof gallery

                    $output .= '
                    <section class="from-the-blog-content">
                        <a href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>';
                    $metas = ot_get_option('pp_meta_blog',array());
                    $output .= ' <div class="meta-tags">';
                    if ($show_author) {
                        $output .= '<span>'.esc_html__('By','workscout'). ' <a class="author-link" itemprop="url" rel="author" href="'.get_author_posts_url(get_the_author_meta('ID',$author_id )).'">'.get_the_author_meta('display_name',$author_id).'</a></span>'.' ';
                    }
                    if ($show_date) {
                        $output .= '<span>'.get_the_date().'</span>';
                    }
                    $excerpt = get_the_excerpt();

                    $output .= '</div>
                            <p>'.workscout_string_limit_words($excerpt,$limit_words).'</p>
                        <a href="'.get_permalink().'" class="button">'.esc_html__("Read More","workscout").'</a>
                    </section>

                </article>
            </div>';
        endwhile;  // close the Loop
    endif;
     $output .= '</div>';
     wp_reset_postdata(); 
    return $output;
}



/*
    Shortcode prints grid of categories with icon boxes
    TODO: images instead of font icons
*/
add_shortcode('jobs_categories', 'workscout_jobs_categories');
function workscout_jobs_categories( $atts ) {
    extract(shortcode_atts(array(
        'title' => "Web, Software & IT",
        'orderby' => 'count',
        'number' => '99',
        'hide_empty' => 0,
        'full_width' => 'yes',
        'type' => 'all',  /* type: group_by_parent/ all / parent */
        'parent_id' => '',
        'from_vs' => ''
    ), $atts));

    $output = '';
    if($full_width == 'yes') {
            if($from_vs === 'yes') {
            $output = '</div> <!-- eof wpb_wrapper -->
                    </div> <!-- eof column_container -->
                    </div> <!-- eof column_container -->
                </div> <!-- eof vc_row-fluid -->
            </article> <!-- eof columns -->
        </div> <!-- eof container -->';
        } else {
             $output = '</article>
            </div>';
        }
    }

    
    if($type == 'all') {
     
        $categories = get_terms( 'job_listing_category', array(
            'orderby'    => $orderby, // id count name - Default slug term_group - Not fully implemented (avoid using) none
            'hide_empty' => $hide_empty,
            'number'     => $number,
         ) );
        if ( !is_wp_error( $categories ) ) {
            $output .= '<div class="categories-group">
                <div class="container">
                    <div class="four columns"><h4 class="parent-jobs-category">'.$title.'</h4></div>';
            $chunks = workscout_partition($categories, 3);
            foreach ($chunks as $chunk) {
                $output .= '<div class="four columns">
                        <ul>';
                        foreach ($chunk as $term) {
                           $output .= ' <li><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></li>';
                        }
                $output .= '</ul>
                    </div>';
            }
            $output .= '</div>
            </div>';
        }
    }

    if($type == 'group_by_parents') {

        $parents =  get_terms("job_listing_category", array(
            'orderby'    => $orderby, // id count name - Default slug term_group - Not fully implemented (avoid using) none
            'hide_empty' => $hide_empty,
            'number'     => $number,
            'parent' => 0
            ));
        if ( !is_wp_error( $parents ) ) {
            foreach($parents as $key => $term) :
                $subterms = get_terms("job_listing_category", array("orderby" => $orderby, "parent" => $term->term_id, 'hide_empty' => $hide_empty));
                if($subterms) :
                    $output .= '<div class="categories-group">
                    <div class="container">
                        <div class="four columns"><h4 class="parent-jobs-category"><a href="' . get_term_link( $term ) . '">'. $term->name .'</a></h4></div>';
                           
                            $chunks = workscout_partition($subterms, 3);
                            foreach ($chunks as $chunk) {
                                $output .= '<div class="four columns">
                                        <ul>';
                                        foreach ($chunk as $subterms) {
                                           $output .= ' <li><a href="' . get_term_link( $subterms ) . '">' . $subterms->name . '</a></li>';
                                        }
                                $output .= '</ul>
                                    </div>';
                            }
                           
                    $output .= '</div>
                    </div>';
                 endif;
            endforeach;
        }
    }

    if($type == 'parent') {
        if ( !is_wp_error( $categories ) ) {
            $subterms =  get_terms("job_listing_category", array(
                'orderby'    => $orderby, // id count name - Default slug term_group - Not fully implemented (avoid using) none
                'hide_empty' => $hide_empty,
                'number'     => $number,
                'parent'     => $parent_id,
                ));
            $term = get_term( $parent_id, "job_listing_category" );
            if($subterms) :
                    $output .= '<div class="categories-group">
                    <div class="container">
                        <div class="four columns"><h4 class="parent-jobs-category"><a href="' . get_term_link( $term ) . '">'. $term->name .'</a></h4></div>';
                           
                            $chunks = workscout_partition($subterms, 3);
                            foreach ($chunks as $chunk) {
                                $output .= '<div class="four columns">
                                        <ul>';
                                        foreach ($chunk as $subterms) {
                                           $output .= ' <li><a href="' . get_term_link( $subterms ) . '">' . $subterms->name . '</a></li>';
                                        }
                                $output .= '</ul>
                                    </div>';
                            }
                           
                    $output .= '</div>
                    </div>';
                 endif;
         }
        
    }

    if($full_width == 'yes') {
       if($from_vs === 'yes') {
            $output .= '
            <div class="container">
                <article class="sixteen columns">
                    <div class="vc_row wpb_row vc_row-fluid">
                        <div class="vc_col-sm-12 wpb_column column_container">
                            <div class="vc_column-inner "><div class="wpb_wrapper">';
        } else {
            $output .= ' <div class="container">
                <article class="sixteen columns">';
        }
    }
    return $output;
}

/**
* Box shortcodes
* Usage: [box type=""] [/box]
*/

function pp_box($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => 'notice'
        ), $atts));
    return '<div class="notification closeable '.$type.'"><p>'.do_shortcode( $content ).'</p></div>';
}
add_shortcode('box', 'pp_box');


function workscout_info_banner( $atts, $content ) {
   extract(shortcode_atts(array(
            'title' => 'Perfect Template for Your Own Job Board',
            'url' => '#',
            'target' => '',
            'buttontext' => 'Get This Theme',
            ), $atts));

    $output = '
    <div class="info-banner">
        <div class="info-content">
            <h3>'.$title.'</h3>
            <p>'.do_shortcode( $content ).'</p>
        </div>';
        if($url) {
            if($target){
                $output .= '<a target="'.$target.'" href="'.$url.'" class="button color">'.$buttontext.'</a>';
            } else {
                $output .= '<a href="'.$url.'" class="button">'.$buttontext.'</a>';
            }
        }
    $output .= '<div class="clearfix"></div>
    </div>';
    return $output;
}
add_shortcode( 'infobanner', 'workscout_info_banner' );


add_shortcode('counter', 'workscout_counter');
function workscout_counter( $atts, $content ) {
   extract(shortcode_atts(array(
            'title' => 'Resumes Posted',
            'number' => '768',
            'scale' => '',
            'from_vs' => '',
            'width' => 'one-third',

    ), $atts));
    $output = '';
    if($from_vs === 'yes') {
        $output .= '<div class="columns '.$width.'">';
    }
    $output .= '<div class="counter-box">
                <span class="counter">'.$number.'</span>';
    if(!empty($scale)) { $output .= '<i>'.$scale.'</i>';}
    $output .= ' <p>'.$title.'</p>
            </div>';
    if($from_vs === 'yes') {
        $output .= '</div>';
    }
    return $output;
}

add_shortcode('counters', 'workscout_counters');
function workscout_counters( $atts, $content ) {
    extract(shortcode_atts(array('from_vs' => 'yes'), $atts));
    if($from_vs === 'yes') {
        $output = '</div> <!-- eof wpb_wrapper -->
                    </div> <!-- eof column_container -->
                </div> <!-- eof vc_row-fluid -->
            </article> <!-- eof columns -->
        </div> <!-- eof container -->';
        } else {
        $output = '</article>
        </div>';
    }


    $output .= '<!-- Counters -->
    <div id="counters">
        <div class="container">
        '.do_shortcode( $content ).'
        </div>
    </div>';

    if($from_vs === 'yes') {
    $output .= '
        <div class="container">
            <article class="sixteen columns">
                <div class="vc_row wpb_row vc_row-fluid">
                    <div class="vc_col-sm-12 wpb_column column_container">
                        <div class="wpb_wrapper">';
    } else {
        $output .= ' <div class="container">
            <article class="sixteen columns">';
    }
    return $output;
}



function pp_pricing_table($atts, $content) {
    extract(shortcode_atts(array(
        "type" => 'color-1',
        "width" => 'four',
        "color" => '',
        "title" => '',
        "currency" => '$',
        "price" => '',
        "discounted" => '',
        "per" => '',
        "buttonstyle" => '',
        "buttonlink" => '',
        "buttontext" => 'Sign Up',
        "place" =>'',
        "from_vs" => 'no'
        ), $atts));

    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }
    $output = '';
    if($from_vs == 'yes') {
        $output .= '
    <div class="'.$type.' plan">';
    } else {
        $output .= '
    <div class="'.$type.' plan '.$width.' '.$p.' columns">';
    }
    $output .= '
        <div class="plan-price" style="background-color: '.$color.';">
            <h3>'.$title.'</h3>';
            if(!empty($discounted)){ 
                    $output .= '<div class="plan-price-wrap"><del><span class="amount">'.$currency.''.$price.'</span></del> <ins><span class="amount">'.$currency.''.$discounted.'</span></ins></div>';                
            } else {

                $output .= '<span class="plan-currency">'.$currency.'</span>
                            <span class="value">'.$price.'</span>';

            }
        $output .= '</div>
        <div class="plan-features">'.do_shortcode( $content );
        if($buttonlink) {
            $output .=' <a class="button"  style="background-color: '.$color.';" href="'.$buttonlink.'"><i class="fa fa-shopping-cart"></i> '.$buttontext.'</a>';
        }
    $output .=' </div>
    </div>';
    return $output;
}

add_shortcode('pricing_table', 'pp_pricing_table');
 

function pp_woo_tables($atts, $content) {
    extract(shortcode_atts(array(
        "type" => 'color-1',
        "from_vs" => 'no'
        ), $atts));
    ob_start();
    global $wp_query;

    $job_packages = new WP_Query( array(
        'post_type'  => 'product',
        'limit'      => -1,
        'tax_query'  => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'job_package'
            )
        )) 
    );
    

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
    $counter = 0;
    while ( $job_packages->have_posts() ) : $job_packages->the_post(); 
            switch ($counter) {
                case '0':
                    $place_class = " alpha";
                    break;
                case $job_packages->found_posts:
                    $place_class = " omega";
                    break;
                
                default:
                    # code...
                    break;
            }
            $counter++;
            
            $job_package = get_product( get_post()->ID ); ?>
        
            <div class="plan <?php if($job_package->is_featured()) { echo "color-2 "; } else { echo "color-1 "; } echo esc_attr($columns);  echo esc_attr($place_class); ?>  column">
                <div class="plan-price">

                    <h3><?php the_title(); ?></h3>
                    <?php echo '<div class="plan-price-wrap">'.$job_package->get_price_html().'</div>'; ?>

                </div>

                <div class="plan-features">
                    <ul>
                        <?php 
                        $jobslimit = $job_package->get_limit();
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
                            <?php esc_html_e('Jobs are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $job_package->get_duration(), 'workscout' ), $job_package->get_duration() ); ?>
                        </li>

                    </ul>
                    <?php 
                        the_content(); 
                    
                        $link   = $job_package->add_to_cart_url();
                        $label  = apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout' ) );
                
                    ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo esc_html($label); ?></a>
                    
                </div>
            </div>
        <?php endwhile; 
    $pricing__output =  ob_get_clean();

    return $pricing__output;
}

add_shortcode('pricing_woo_tables', 'pp_woo_tables');
   

/*
 * Helpers
 */
function workscout_string_to_bool( $value ) {
    return ( is_bool( $value ) && $value ) || in_array( $value, array( '1', 'true', 'yes' ) ) ? true : false;
}

function workscout_partition( $list, $p ) {
    $listlen = count( $list );
    $partlen = floor( $listlen / $p );
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice( $list, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}


/* Visual Composer Shortcodes*/


function vc_workscout_clients_carousel($atts, $content ) {
    extract(shortcode_atts(array(
        'width' => 'sixteen',
        'logos' => ''
        ), $atts));

    $output = '';
    $width_arr = array(
        'sixteen' => 16, 'fifteen' => 15, 'fourteen' => 14, 'thirteen' => 13, 'twelve' => 12, 'eleven' => 11, 'ten' => 10, 'nine' => 9,
        'eight' => 8, 'seven' => 7, 'six' => 6, 'five' => 5, 'four' => 4, 'three' => 3
        );
    $randID = rand(1, 99); // Get unique ID for carousel
    if(empty($width)) { $width = "sixteen"; }
    $carousel_width = $width_arr[$width] - 2;
    $carousel_key_width = array_search ($carousel_width, $width_arr);
    $output .= ' <!-- Navigation / Left -->
    <div class="one carousel column alpha"><div id="showbiz_left_'.$randID.'" class="sb-navigation-left-2"><i class="fa fa-angle-left"></i></div></div>

    <!-- ShowBiz Carousel -->
    <div id="our-clients" class="our-clients-run showbiz-container '.$carousel_key_width.' carousel columns" >

    <!-- Portfolio Entries -->
    <div class="showbiz our-clients" data-left="#showbiz_left_'.$randID.'" data-right="#showbiz_right_'.$randID.'">
        <div class="overflowholder"><ul>';
    if(!empty($logos)){
        $logos = explode(',', $logos);
        foreach ($logos as $logo) {
            $logosrc = wp_get_attachment_url( $logo );
            $output .= '<li><img src="'.$logosrc.'"></li>';
        }
    }
    $output .='</ul><div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
    <!-- Navigation / Right -->
    <div class="one carousel column omega"><div id="showbiz_right_'.$randID.'" class="sb-navigation-right-2"><i class="fa fa-angle-right"></i></div></div>';

    return $output;
}
add_shortcode('vc_clients_carousel', 'vc_workscout_clients_carousel');





/**
* Accordion shortcode
* Usage: [accordion title="Tab"] [/accordion]
*/
if (!function_exists('pp_accordion')) {
    function pp_accordion( $atts, $content ) {
        extract(shortcode_atts(array(
            'title' => 'Tab'
            ), $atts));
        return '<h3><span class="ui-accordion-header-icon ui-icon ui-accordion-icon"></span>'.$title.'</h3><div><p>'.do_shortcode( $content ).'</p></div>';
    }
    add_shortcode( 'accordion', 'pp_accordion' );

    function pp_accordion_wrap( $atts, $content ) {
        extract(shortcode_atts(array(), $atts));
        return '<div class="accordion">'.do_shortcode( $content ).'</div>';
    }
    add_shortcode( 'accordionwrap', 'pp_accordion_wrap' );
}


function etdc_tab_group( $atts, $content ) {
    $GLOBALS['pptab_count'] = 0;
    do_shortcode( $content );
    $count = 0;
    if( is_array( $GLOBALS['tabs'] ) ) {
        foreach( $GLOBALS['tabs'] as $tab ) {
            $count++;
            $tabs[] = '<li><a href="#tab'.$count.'">'.$tab['title'].'</a></li>';
            $panes[] = '<div class="tab-content" id="tab'.$count.'">'.$tab['content'].'</div>';
        }
        $return = "\n".'<ul class="tabs-nav">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="tabs-container">'.implode( "\n", $panes ).'</div>'."\n";
    }
    return $return;
}

/**
* Usage: [tab title="" ] [/tab]
*/
function etdc_tab( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => 'Tab %d',
        ), $atts));

    $x = $GLOBALS['pptab_count'];
    $GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['pptab_count'] ), 'content' =>  do_shortcode( $content ) );
    $GLOBALS['pptab_count']++;
}
add_shortcode( 'tabgroup', 'etdc_tab_group' );

add_shortcode( 'tab', 'etdc_tab' );


?>
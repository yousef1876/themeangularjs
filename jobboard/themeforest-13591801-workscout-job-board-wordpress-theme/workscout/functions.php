<?php
/**
 * WorkScout functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WorkScout
 */

remove_filter( 'the_title','add_breadcrumb_to_the_title'  );
include_once( get_template_directory() . '/kirki/kirki.php' );

function workscout_kirki_update_url( $config ) {

    $config['url_path'] = get_template_directory_uri() . '/kirki/';
    return $config;

}
add_filter( 'kirki/config', 'workscout_kirki_update_url' );

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );


/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Show New Layout
 */
add_filter( 'ot_show_new_layout', '__return_false' );


/**
 * Custom Theme Option page
 */
add_filter( 'ot_use_theme_options', '__return_true' );

/**
 * Meta Boxes
 */
add_filter( 'ot_meta_boxes', '__return_true' );

/**
 * Loads the meta boxes for post formats
 */
add_filter( 'ot_post_formats', '__return_true' );

/**
 * Required: include OptionTree.
 */
require( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/theme-options.php' );

/**
 * Meta Boxes
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/meta-boxes.php' );


if ( ! function_exists( 'workscout_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */


add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

function workscout_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WorkScout, use a find and replace
	 * to change 'workscout' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'workscout', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'resume-manager-templates' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	do_action( 'purethemes-testimonials' );
	
	/*
	 * Enabling Full Template Support for WP Job Manager
	 */
	add_theme_support( 'job-manager-templates' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(840, 430, true); //size of thumbs
	add_image_size('workscout-small-thumb', 96, 105, true);     //slider
	add_image_size('workscout-small-blog', 498, 315, true);     //slider
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'workscout' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'workscout_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // workscout_setup
add_action( 'after_setup_theme', 'workscout_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function workscout_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'workscout_content_width', 860 );
}
add_action( 'after_setup_theme', 'workscout_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function workscout_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'workscout' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Jobs page sidebar', 'workscout' ),
		'id'            => 'sidebar-jobs',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Single job sidebar before', 'workscout' ),
		'id'            => 'sidebar-job-before',
		'description'   => 'This widgets will be displayed before the Job Overview on single job page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Single job sidebar after', 'workscout' ),
		'id'            => 'sidebar-job-after',
		'description'   => 'This widgets will be displayed after the Job Overview on single job page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Resumes page sidebar', 'workscout' ),
		'id'            => 'sidebar-resumes',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Shop page sidebar', 'workscout' ),
		'id'            => 'sidebar-shop',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar(array(
		'id' => 'footer1',
		'name' => esc_html__('Footer 1st Column', 'workscout' ),
		'description' => esc_html__('1st column for widgets in Footer', 'workscout' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer2',
		'name' => esc_html__('Footer 2nd Column', 'workscout' ),
		'description' => esc_html__('2nd column for widgets in Footer', 'workscout' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer3',
		'name' => esc_html__('Footer 3rd Column', 'workscout' ),
		'description' => esc_html__('3rd column for widgets in Footer', 'workscout' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer4',
		'name' => esc_html__('Footer 4th Column', 'workscout' ),
		'description' => esc_html__('4th column for widgets in Footer', 'workscout' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	if (ot_get_option('incr_sidebars')):
		$pp_sidebars = ot_get_option('incr_sidebars');
		foreach ($pp_sidebars as $pp_sidebar) {
			register_sidebar(array(
				'name' => $pp_sidebar["title"],
				'id' => $pp_sidebar["id"],
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
				));
		}
	endif;
}
add_action( 'widgets_init', 'workscout_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function workscout_scripts() {

	wp_register_style( 'workscout-base', get_template_directory_uri(). '/css/base.css' );
    wp_register_style( 'workscout-responsive', get_template_directory_uri(). '/css/responsive.css' );
    wp_register_style( 'workscout-font-awesome', get_template_directory_uri(). '/css/font-awesome.css' );
	wp_enqueue_style( 'workscout-style', get_stylesheet_uri(), array('workscout-base','workscout-responsive','workscout-font-awesome') );
	wp_enqueue_style( 'workscout-woocommerce', get_template_directory_uri(). '/css/woocommerce.css' );
	wp_dequeue_style('wp-job-manager-frontend');
	wp_dequeue_style('wp-job-manager-resume-frontend');
	wp_dequeue_style('chosen');

	wp_deregister_script( 'wp-job-manager-bookmarks-bookmark-js');
	wp_dequeue_style( 'wp-job-manager-bookmarks-frontend' );
	wp_dequeue_style( 'wp-job-manager-applications-frontend' );


	if ( defined( 'JOB_MANAGER_VERSION' ) ) {
	    global $wpdb;
		$ajax_url  = WP_Job_Manager_Ajax::get_endpoint();
		$min = floor( $wpdb->get_var(
	    $wpdb->prepare('
	            SELECT min(meta_value + 0)
	            FROM %1$s
	            LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
	            WHERE meta_key IN ("' . implode( '","', array( '_salary') ) . '")
	            AND meta_value != ""
	        ', $wpdb->posts, $wpdb->postmeta )
	    ) );
	            
		$max = ceil( $wpdb->get_var(
		$wpdb->prepare('
		    SELECT max(meta_value + 0)
		    FROM %1$s
		    LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
		    WHERE meta_key IN ("' . implode( '","', array( '_salary' ) ) . '")
		', $wpdb->posts, $wpdb->postmeta, '_price' )
		) );

		$ratemin = floor( $wpdb->get_var(
	    $wpdb->prepare('
	            SELECT min(meta_value + 0)
	            FROM %1$s
	            LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
	            WHERE meta_key IN ("' . implode( '","',  array( '_rate') ) . '")
	            AND meta_value != ""
	        ', $wpdb->posts, $wpdb->postmeta )
	    ) );	

	    $ratemax = ceil( $wpdb->get_var(
		$wpdb->prepare('
		    SELECT max(meta_value + 0)
		    FROM %1$s
		    LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
		    WHERE meta_key IN ("' . implode( '","',  array( '_rate' ) ) . '")
		', $wpdb->posts, $wpdb->postmeta, '_price' )
		) );
		wp_dequeue_script('wp-job-manager-ajax-filters' );
		wp_deregister_script('wp-job-manager-ajax-filters');
		wp_register_script( 'workscout-wp-job-manager-ajax-filters', get_template_directory_uri() . '/js/workscout-ajax-filters.js', array( 'jquery', 'jquery-deserialize' ), '20150705', true );
		wp_localize_script( 'workscout-wp-job-manager-ajax-filters', 'job_manager_ajax_filters', array(
				'ajax_url'                	=> $ajax_url,
				'is_rtl'                  	=> is_rtl() ? 1 : 0,
				'lang'                    	=> defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : '', // WPML workaround until this is standardized
				'i18n_load_prev_listings' 	=> esc_html__( 'Load previous listings', 'workscout' ),
				'salary_min'		      	=> $min,
				'salary_max'		      	=> $max,
				'rate_min'		      		=> $ratemin,
				'rate_max'		      		=> $ratemax,
				'currency'		      		=> get_workscout_currency_symbol(),

			) );
		$ajax_url = admin_url( 'admin-ajax.php', 'relative' );

		
		$resume_ratemin = floor( $wpdb->get_var(
	    $wpdb->prepare('
	            SELECT min(meta_value + 0)
	            FROM %1$s
	            LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
	            WHERE meta_key IN ("' . implode( '","',  array( '_rate') ) . '")
	            AND meta_value != ""
	        ', $wpdb->posts, $wpdb->postmeta )
	    ) );	

	    $resume_ratemax = ceil( $wpdb->get_var(
		$wpdb->prepare('
		    SELECT max(meta_value + 0)
		    FROM %1$s
		    LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
		    WHERE meta_key IN ("' . implode( '","',  array( '_rate' ) ) . '")
		', $wpdb->posts, $wpdb->postmeta, '_price' )
		) );
		wp_dequeue_script('wp-resume-manager-ajax-filters' );
		wp_deregister_script('wp-resume-manager-ajax-filters');
		wp_register_script( 'workscout-wp-resume-manager-ajax-filters', get_template_directory_uri() . '/js/workscout-resumes-ajax-filters.js', array( 'jquery', 'jquery-deserialize' ), '20150705', true );
		wp_localize_script( 'workscout-wp-resume-manager-ajax-filters', 'resume_manager_ajax_filters', array(
			'ajax_url' => $ajax_url,
			'rate_min'		      		=> $ratemin,
			'rate_max'		      		=> $ratemax,
			'currency'		      		=> get_workscout_currency_symbol(),
		) );

	}
	
	wp_enqueue_script( 'suggest' );
	
	wp_enqueue_script( 'workscout-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_script('jquery-ui-slider'); 
	
	wp_enqueue_script( 'workscout-chosen', get_template_directory_uri() . '/js/chosen.jquery.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-hoverIntent', get_template_directory_uri() . '/js/hoverIntent.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-counterup', get_template_directory_uri() . '/js/jquery.counterup.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '20150705', true );
	
	wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js' );
	wp_enqueue_script( 'workscout-gmaps', get_template_directory_uri() . '/js/jquery.gmaps.min.js', array('jquery'), '20150705', true );
	
	
	wp_enqueue_script( 'workscout-jpanelmenu', get_template_directory_uri() . '/js/jquery.jpanelmenu.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), '20150705', true );
	wp_enqueue_script( 'workscout-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-tools', get_template_directory_uri() . '/js/jquery.themepunch.tools.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-showbizpro', get_template_directory_uri() . '/js/jquery.themepunch.showbizpro.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-stacktable', get_template_directory_uri() . '/js/stacktable.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '20150705', true );
	wp_enqueue_script( 'workscout-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '20150705', true );

	wp_localize_script( 'workscout-custom', 'ws',
    array(
        'logo'=> Kirki::get_option( 'workscout','pp_logo_upload', ''),
        'retinalogo'=> Kirki::get_option( 'workscout','pp_retina_logo_upload',''),
        )
    );

	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'workscout_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom registration form
 */

require get_template_directory() . '/inc/registration.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Job Menager related stuff
 */
require get_template_directory() . '/inc/wp-job-manager.php';

/**
 * Load shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Load ptshortcodes
 */
require get_template_directory() . '/inc/ptshortcodes.php';

/**
 * Load woocommerce 
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load TGMPA.
 */
require get_template_directory() . '/inc/tgmpa.php';

/**
 * Load widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load Envato.
 */
require get_template_directory() . '/inc/github.php';

  
/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'workscout_vcSetAsTheme' );
function workscout_vcSetAsTheme() {
    vc_set_as_theme( $disable_updater = true );
}

function workscout_remove_frontend_links() {
    vc_disable_frontend(); // this will disable frontend editor
}
add_action( 'vc_after_init', 'workscout_remove_frontend_links' );

/**
 * Load Visual Composer compatibility file.
 */

if(function_exists('vc_map')) {
    require_once get_template_directory() . '/inc/vc.php';
    //require_once get_template_directory() . '/inc/vc_modified_shortcodes.php';
}

<?php
/**
 * WorkScout Theme Customizer.
 *
 * @package WorkScout
 */


Kirki::add_config( 'workscout', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'option',
    'option_name'   => 'workscout',
) );

/*section blog*/

Kirki::add_section( 'blog', array(
    'title'          => esc_html__( 'Blog Options', 'workscout'  ),
    'description'    => esc_html__( 'Blog related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_blog_layout',
	    'label'       => esc_html__( 'Blog layout', 'workscout' ),
	    'description' => esc_html__( 'Choose the sidebar side for blog', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => 'left-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_meta_single',
	    'label'       => esc_html__( 'Post meta informations on single post', 'workscout' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'workscout' ),
	        'date' 		=> esc_html__( 'Date', 'workscout' ),
	        'tags' 		=> esc_html__( 'Tags', 'workscout' ),
	        'cat' 		=> esc_html__( 'Categories', 'workscout' ),
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_blog_meta',
	    'label'       => esc_html__( 'Post meta informations on blog post', 'workscout' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display on blog and archive pages', 'workscout' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'workscout' ),
	        'date' 		=> esc_html__( 'Date', 'workscout' ),
	        'tags' 		=> esc_html__( 'Tags', 'workscout' ),
	        'cat' 		=> esc_html__( 'Categories', 'workscout' ),
	        'com' 		=> esc_html__( 'Comments', 'workscout' ),
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'    => 'pp_blog_title',
	    'label'       => esc_html__( 'Blog title', 'workscout' ),
	    'default'     => esc_html__( 'Blog', 'workscout' ),
	    'section'     => 'blog',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'text',
	    'settings'    => 'pp_blog_subtitle',
	    'label'       => esc_html__( 'Blog subtitle', 'workscout' ),
	    'default'     => esc_html__( 'Keep up to date with the latest news', 'workscout' ),
	    'section'     => 'blog',
	    'priority'    => 10,
	) );


	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_logo_upload',
	    'label'       => esc_html__( 'Logo image', 'workscout' ),
	    'description' => esc_html__( 'Upload logo for your website', 'workscout' ),
	    'section'     => 'title_tagline',
	    'default'     => '',
	    'priority'    => 10,
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_retina_logo_upload',
	    'label'       => esc_html__( 'Retina Logo image', 'workscout' ),
	    'description' => esc_html__( 'Upload Retina logo for your website', 'workscout' ),
	    'section'     => 'title_tagline',
	    'default'     => '',
	    'priority'    => 10,
	) );

Kirki::add_section( 'layout', array(
    'title'          => esc_html__( 'Layout Options', 'workscout'  ),
    'description'    => esc_html__( 'Layout and header options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_body_style',
	    'label'       => esc_html__( 'Layout style', 'workscout' ),
	    'section'     => 'layout',
	    'description' => '',
	    'default'     => 'fullwidth',
	    'priority'    => 10,
	    'choices'     => array(
	        'boxed'		=> esc_html__( 'Boxed', 'workscout' ),
	        'fullwidth' => esc_html__( 'Full-width', 'workscout' ),
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'select',
	    'settings'    => 'pp_header_style',
	    'label'       => esc_html__( 'Header style', 'kirki' ),
	    'section'     => 'layout',
	    'description' => '',
	    'default'     => 'default',
	    'priority'    => 11,
	    'choices'     => array(
	        'default'		=> esc_html__( 'Default', 'workscout' ),
	        'alternative' 	=> esc_html__( 'Alternative', 'workscout' ),
	        'full-width' 	=> esc_html__( 'Full-width', 'workscout' ),
	    ),
	) );

Kirki::add_section( 'shop', array(
    'title'          => esc_html__( 'WooCommerce Options', 'workscout'  ),
    'description'    => esc_html__( 'Shop related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_shop_layout',
	    'label'       => esc_html__( 'Shop layout', 'workscout' ),
	    'description' => esc_html__( 'Choose the sidebar side for shop', 'workscout' ),
	    'section'     => 'shop',
	    'default'     => 'full-width',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	        'full-width' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/full-width.png',
	    ),
	) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_pricingtable_mode',
	    'label'       => esc_html__( 'Enable Pricing Table mode', 'kirki' ),
	    'section'     => 'shop',
	    'description' => esc_html__( 'With this setting set to On, products will be displayed as Pricing Tables', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,
	
	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_shop_ordering',
	    'label'       => esc_html__( 'Show/hide results count and order select on shop page', 'kirki' ),
	    'section'     => 'shop',
	    'description' => esc_html__( 'With this setting set to On, results count and order select on shop page will be displayed', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,
	) );


Kirki::add_field( 'workscout', array(
    'type'        => 'color',
    'settings'    => 'pp_main_color',
    'label'       => esc_html__( 'Select main theme color', 'kirki' ),
    'section'     => 'colors',
    'default'     => '#58ba2b',
    'priority'    => 10,
) );

Kirki::add_section( 'header', array(
    'title'          => esc_html__( 'Header Options', 'workscout'  ),
    'description'    => esc_html__( 'Header related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 150,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_login_form_status',
	    'label'       => esc_html__( 'Login/Sing Up buttons in header', 'kirki' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable Login/Sing Up buttons in header', 'workscout' ),
	    'default'     => true,
	    'priority'    => 10,

	) );	

	Kirki::add_field( 'workscout', array(
	    'type'        => 'switch',
	    'settings'    => 'pp_minicart_in_header',
	    'label'       => esc_html__( 'Mini shop cart in header', 'kirki' ),
	    'section'     => 'header',
	    'description' => esc_html__( 'Enable/disable mini shop cart in header', 'workscout' ),
	    'default'     => false,
	    'priority'    => 10,
	
	) );


Kirki::add_section( 'footer', array(
    'title'          => esc_html__( 'Footer Options', 'workscout'  ),
    'description'    => esc_html__( 'Footer related options', 'workscout'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	Kirki::add_field( 'workscout', array(
	    'type'        => 'textarea',
	    'settings'    => 'pp_copyrights',
	    'label'       => esc_html__( 'Copyrights text', 'workscout' ),
	    'default'     => '&copy; Theme by Purethemes.net. All Rights Reserved.',
	    'section'     => 'footer',
	    'priority'    => 10,
	) );

	Kirki::add_field( 'workscout', array(
    'type'        => 'select',
    'settings'    => 'pp_footer_widgets',
    'label'       => esc_html__( 'Footer widgets layout', 'kirki' ),
    'description' => esc_html__( 'Total width of footer is 16 columns, here you can decide layout based on columns number for each widget area in footer', 'kirki' ),
    'section'     => 'footer',
    'default'     => '5,3,3,5',
    'priority'    => 10,
    'choices'     => array(
        '7,3,6'		=> esc_html__( '7 | 3 | 6', 'kirki' ),
        '7,3,3,3' 	=> esc_html__( '7 | 3 | 3 | 3', 'kirki' ),
        '5,3,3,5' 	=> esc_html__( '5 | 3 | 3 | 5', 'kirki' ),
        '4,4,4,4' 	=> esc_html__( '4 | 4 | 4 | 4', 'kirki' ),
        '8,8' 		=> esc_html__( '8 | 8', 'kirki' ),
        '1/3,2/3' 	=> esc_html__( '1/3 | 2/3', 'kirki' ),
        '2/3,1/3' 	=> esc_html__( '2/3 | 1/3', 'kirki' ),
        '1/3,1/3,1/3' 	=> esc_html__( '1/3 | 1/3 | 1/3', 'kirki' ),
    ),
	) );


add_action('wp_head', 'workscout_stylesheet_content');


function workscout_generate_typo_css($typo){
    if($typo){
        $wpv_ot_default_fonts = array('arial','georgia','helvetica','palatino','tahoma','times','trebuchet','verdana');        
        $ot_google_fonts = get_theme_mod( 'ot_google_fonts', array() );
        foreach ($typo as  $key => $value) {
            if(isset($value) && !empty($value)) {
                if($key=='font-color') { $key = "color"; }
                if($key=='font-family') { 
                    if ( ! in_array( $value, $wpv_ot_default_fonts ) ) {
                        $value = $ot_google_fonts[$value]['family']; } 
                    }
                echo $key.":".$value.";";
                
            }
        }
    }
}

function workscout_generate_bg_css($typo){
    if($typo){
        foreach ($typo as  $key => $value) {
            if(isset($value) && !empty($value)) {
                if($key=='background-image') $value = "url('".$value."')";
                echo esc_attr($key).":".$value.";";
            }
        }
    }
}


function mobile_menu_css(){
    $bodytypo = ot_get_option( 'workscout_body_font');
    $menutypo = ot_get_option( 'workscout_menu_font');
    $logotypo = ot_get_option( 'workscout_logo_font');
    $headerstypo = ot_get_option( 'workscout_headers_font');

    $ot_google_fonts = get_theme_mod( 'ot_google_fonts', array() );
 
    if(isset($bodytypo['font-family'])) {
        $tempfamily = $bodytypo['font-family'];
        
        $wpv_ot_default_fonts = array('arial','georgia','helvetica','palatino','tahoma','times','trebuchet','verdana');
        if(!empty($tempfamily)) {
	        if ( in_array( $tempfamily, $wpv_ot_default_fonts ) ) {
	            $family = $tempfamily;
	        } else {
	            $ot_google_fonts = get_theme_mod( 'ot_google_fonts', array() );
	            $family = $ot_google_fonts[$tempfamily]['family'];  
	        }
        }
    } else {
        $family = '';
    }
?>
<style type="text/css">

<?php if($family){ ?>
    body,
    input[type="text"],
    input[type="password"],
    input[type="email"],
    textarea,
    select,
    input.newsletter,
    .map-box p,select#archives-dropdown--1, select#cat, select#categories-dropdown--1,
    .widget_search input.search-field, .widget_text select,.map-box p {
        font-family: "<?php echo $family; ?>";
    }
<?php } ?>
    body { <?php workscout_generate_typo_css($bodytypo); ?> }
    h1, h2, h3, h4, h5, h6  { <?php workscout_generate_typo_css($headerstypo); ?> }
    #logo h1 a, #logo h2 a { <?php workscout_generate_typo_css($logotypo); ?> }
    body .menu ul > li > a, body .menu ul li a {  <?php workscout_generate_typo_css($menutypo); ?>  }
   
    </style>
  <?php
}
add_action('wp_head', 'mobile_menu_css');


function workscout_stylesheet_content() { 

$maincolor = Kirki::get_option( 'workscout', 'pp_main_color' ); 

?>
<style type="text/css">
/* ------------------------------------------------------------------- */
/* Green #58ba2b
---------------------------------------------------------------------- */
.current-menu-item > a,a.button.gray.app-link.opened,ul.float-right li a:hover,.menu ul li.sfHover a.sf-with-ul,.menu ul li a:hover,a.menu-trigger:hover,
.current-menu-parent a,#jPanelMenu-menu li a:hover,.search-container button,.upload-btn,button,input[type="button"],input[type="submit"],a.button,
.upload-btn:hover,#titlebar.photo-bg a.button.white:hover,a.button.dark:hover,#backtotop a:hover,.mfp-close:hover,.tabs-nav li.active a, .tabs-nav-o li.active a,.ui-accordion .ui-accordion-header-active:hover,
.ui-accordion .ui-accordion-header-active,.highlight.color, .plan.color-2 .plan-price,.plan.color-2 a.button,.tp-leftarrow:hover,.tp-rightarrow:hover,
.pagination ul li a.current-page,.woocommerce-pagination .current,.pagination .current,.pagination ul li a:hover,.pagination-next-prev ul li a:hover,
.infobox,.load_more_resumes,.job-manager-pagination .current,.hover-icon,.comment-by a.reply:hover,.chosen-container .chosen-results li.highlighted,
.chosen-container-multi .chosen-choices li.search-choice,.list-search button,.checkboxes input[type=checkbox]:checked + label:before, .listings-loader,
.widget_range_filter .ui-state-default,.tagcloud a:hover,#wp-calendar tbody td#today,.footer-widget .tagcloud a:hover,.nav-links a:hover,
.comment-by a.comment-reply-link:hover,#jPanelMenu-menu .current-menu-item > a { background-color: <?php echo esc_attr($maincolor); ?>; }

a,table td.title a:hover,table.manage-table td.action a:hover,#breadcrumbs ul li a:hover,#titlebar span.icons a:hover,.counter-box i,
.counter,#popular-categories li a i,.list-1 li:before,.dropcap,.resume-titlebar span a:hover i,.resumes-content h4,.job-overview ul li i,
.company-info span a:hover,.infobox a:hover,.meta-tags span a:hover,.widget-text h5 a:hover,.app-content .info span ,.app-content .info ul li a:hover,
table td.job_title a:hover,table.manage-table td.action a:hover,.job-spotlight span a:hover,.widget_rss li:before,.widget_rss li a:hover,
.widget_categories li:before,.widget-out-title_categories li:before,.widget_archive li:before,.widget-out-title_archive li:before,
.widget_recent_entries li:before,.widget-out-title_recent_entries li:before,.categories li:before,.widget_meta li:before,.widget_recent_comments li:before,
.widget_nav_menu li:before,.widget_pages li:before,.widget_categories li a:hover,.widget-out-title_categories li a:hover,.widget_archive li a:hover,
.widget-out-title_archive li a:hover,.widget_recent_entries li a:hover,.widget-out-title_recent_entries li a:hover,.categories li a:hover,
.widget_meta li a:hover,#wp-calendar tbody td a,.widget_nav_menu li a:hover,.widget_pages li a:hover,.resume-title a:hover, .company-letters a:hover, .companies-overview li li a:hover,
#titlebar .company-titlebar span a:hover{ color:  <?php echo esc_attr($maincolor); ?>; }

.resumes li a:before,.resumes-list li a:before,.job-list li a:before,table.manage-table tr:before {	-webkit-box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);	-moz-box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);	box-shadow: 0px 1px 0px 0px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);}
#popular-categories li a:before {-webkit-box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);-moz-box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);box-shadow: 0px 0px 0px 1px rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7);}
table.manage-table tr:hover td,.resumes li:hover,.job-list li:hover { border-color: rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.7); }

table.manage-table tr:hover td,.resumes li:hover,.job-list li:hover, #popular-categories li a:hover { background-color: rgba(<?php echo workscout_hex2rgb($maincolor, true) ?>,0.05); }

<?php $bannerbg = ot_get_option('pp_jobs_search_bg'); ?>
#banner.workscout-search-banner {
      <?php workscout_generate_bg_css($bannerbg) ?>
}

<?php $ordering = Kirki::get_option( 'workscout', 'pp_shop_ordering' ); 
if($ordering) { ?>
	.woocommerce-ordering { display: none; }
	.woocommerce-result-count { display: none; }
<?php } ?>

<?php echo ot_get_option( 'pp_custom_css' );  ?>

</style>

<?php }	



/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */
function workscout_hex2rgb($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

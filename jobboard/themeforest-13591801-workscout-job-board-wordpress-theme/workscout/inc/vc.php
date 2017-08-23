<?php

// Visual Composer related functions to implement it with WorkScout

$icons = workscout_icons_list();


/*
 * [box_job_categories] Dispays nicely styled grid of job categories with icons
 *
 */


add_action( 'init', 'ws_box_job_categories_integrateWithVC' );
function ws_box_job_categories_integrateWithVC() {
  $box_jobs_categories = array('None' => ' ');

  $job_listing_categories = get_terms( 'job_listing_category', 'orderby=count&hide_empty=0' );
  if ( is_array( $job_listing_categories ) && ! empty( $job_listing_categories ) ) {
    foreach ( $job_listing_categories as $job_listing_category ) {
        $box_jobs_categories[ $job_listing_category->name ] =  esc_attr($job_listing_category->term_id) ;
    }
  }
  vc_map( array(
    "name" => esc_html__("Job categories grid","workscout"),
    "base" => "box_job_categories",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Dispays nicely styled grid of job categories with icons', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Empty categories..", 'workscout'),
        "param_name" => "hide_empty",
        "value" => array(
         'Hide' => '1',     
         'Show' => '0',
        ),
        'save_always' => true,
        "description" => "Hides categories that doesn't have any jobs"
      ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Name', 'workscout' ) => 'naem',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Count', 'workscout' ) => 'count',
          esc_html__( 'Slug', 'workscout' ) => 'slug',
          esc_html__( 'None', 'workscout' ) => 'none',
          ),
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
      ),

       array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Total items', 'workscout' ),
        'param_name' => 'number',
        'value' => 10, // default value
        'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),

      array(
        'type' => 'checkbox',
        'heading' => esc_html__( '"Browse categories" button', 'workscout' ),
        'param_name' => 'browse_link',
        'description' => esc_html__( 'If checked the button will be added to the end of the grid.', 'workscout' ),
        'value' => array( esc_html__( 'Yes', 'workscout' ) => 'yes' )
      ),

      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Include only', 'workscout' ),
        'param_name' => 'include',
        'description' => esc_html__( 'Add job categories.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
        ),      
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude only', 'workscout' ),
        'param_name' => 'exclude',
        'description' => esc_html__( 'Add job categories.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Child of', 'workscout' ),
        'param_name' => 'child_of',
        'value' => $box_jobs_categories,
      ),
    )
  ));
}

add_filter( 'vc_autocomplete_box_job_categories_include_callback',
  'vc_include_job_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_box_job_categories_include_render',
  'vc_include_job_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_box_job_categories_exclude_callback',
  'vc_include_job_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_box_job_categories_exclude_render',
  'vc_include_job_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)



/*
 * Headline for Visual Composer
 *
 */
add_action( 'init', 'pp_headline_integrateWithVC' );
function pp_headline_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Headline","workscout"),
    "base" => "headline",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Header', 'workscout' ),
//    'admin_enqueue_js' => array(get_template_directory_uri().'/vc_templates/js/vc_image_caption_box.js'),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'content',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Type', 'workscout' ),
        'param_name' => 'type',
        'description' => esc_html__( 'Choose header weight', 'workscout' ),
        'value' => array(
          'H1' => 'H1',
          'H2' => 'H2',
          'H3' => 'H3',
          'H4' => 'H4',
          'H5' => 'H5',
          ),
        'std' => 'h3',
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Top margin', 'workscout' ),
        'param_name' => 'margintop',
        'value' => array(
          '0' => '0',
          '10' => '10',
          '15' => '15',
          '20' => '20',
          '25' => '25',
          '30' => '30',
          '35' => '35',
          '40' => '40',
          '45' => '45',
          '50' => '50',
          ),
        'std' => '15',
        'description' => esc_html__( 'Choose top margin (in px)', 'workscout' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Bottom margin', 'workscout' ),
        'param_name' => 'marginbottom',
        'value' => array(
          '0' => '0',
          '10' => '10',
          '15' => '15',
          '20' => '20',
          '25' => '25',
          '30' => '30',
          '35' => '35',
          '40' => '40',
          '45' => '45',
          '50' => '50',
          ),
        'std' => '35',
        'description' => esc_html__( 'Choose bottom margin (in px)', 'workscout' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Clearfix after?', 'workscout' ),
        'param_name' => 'clearfix',
        'description' => esc_html__( 'Add clearfix after headline, you might want to disable it for some elements, like the recent products carousel.', 'workscout' ),
        'value' => array(
          esc_html__( 'Yes, please', 'workscout' ) => '1',
          esc_html__( 'No, thank you', 'workscout' ) => 'no',
          ),
        'std' => '1',
        ),
      ),
  ));
}



/*
 * [spotlight_jobs] 
 *
 */
add_action( 'init', 'ws_spotlight_jobs_integrateWithVC' );
function ws_spotlight_jobs_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Featured jobs carousel","workscout"),
    "base" => "spotlight_jobs",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows carousel with selected jobs', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'per_page',
          'value' => 3, // default value
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Featured', 'workscout' ) => 'featured',
          esc_html__( 'Date', 'workscout' ) => 'date',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Author', 'workscout' ) => 'author',
          esc_html__( 'Title', 'workscout' ) => 'title',
          esc_html__( 'Modified', 'workscout' ) => 'modified',
          esc_html__( 'Random', 'workscout' ) => 'rand',
          ),
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout' )
      ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'From Categories only', 'workscout' ),
        'param_name' => 'categories',
        'description' => esc_html__( 'Add job categories.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),        
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'From job types only', 'workscout' ),
        'param_name' => 'job_types',
        'description' => esc_html__( 'Add job types.', 'workscout' ),
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Filled', 'workscout' ),
        'param_name' => 'filled',
        'value' => array(
          esc_html__( 'Show all', 'workscout' ) => 'null',
          esc_html__( 'Show only filled', 'workscout' ) => 'true',
          esc_html__( 'Hide filled', 'workscout' ) => 'false'
          ),
        'save_always' => true,
      ),       
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Visible Elements', 'workscout' ),
        'param_name' => 'visible',
        'description' => esc_html__( 'How many elements are visible at once for each screen size (desktop, netbook, tablet, mobile phone).', 'workscout' ),
        'value' => array(
          esc_html__( '1,1,1,1', 'workscout' ) => '1,1,1,1',
          esc_html__( '2,1,1,1', 'workscout' ) => '2,1,1,1',
          esc_html__( '2,2,1,1', 'workscout' ) => '2,2,1,1',
          esc_html__( '3,2,1,1', 'workscout' ) => '3,2,1,1',
          esc_html__( '3,3,1,1', 'workscout' ) => '3,3,2,1',
          esc_html__( '4,3,2,2', 'workscout' ) => '4,3,2,2',
          ),
        'save_always' => true,
      ),      
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Featured', 'workscout' ),
        'param_name' => 'featured',
        'value' => array(
          esc_html__( 'Show all', 'workscout' ) => 'false',
          esc_html__( 'Show only featured', 'workscout' ) => 'true',
          ),
        'save_always' => true,
      ),
    ),
  ));
}
add_filter( 'vc_autocomplete_spotlight_jobs_categories_callback',
  'vc_include_job_categories_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_spotlight_jobs_categories_render',
  'vc_include_job_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_spotlight_jobs_job_types_callback',
  'vc_include_job_types_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_spotlight_jobs_job_types_render',
  'vc_include_job_types_render', 10, 1 ); // Render exact product. Must return an array (label,value)




/*
 * [testimonials_wide] 
 *
 */
add_action( 'init', 'ws_testimonials_wide_integrateWithVC' );
function ws_testimonials_wide_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Testimonials (wide version)","workscout"),
    "base" => "testimonials_wide",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows clients testimonials - add only for full-width rows', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'per_page',
          'value' => 4, // default value
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(

          esc_html__( 'Date', 'workscout' ) => 'date',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Author', 'workscout' ) => 'author',
          esc_html__( 'Title', 'workscout' ) => 'title',
          esc_html__( 'Modified', 'workscout' ) => 'modified',
          esc_html__( 'Random', 'workscout' ) => 'rand',
          ),
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
      ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude Testomionials', 'workscout' ),
        'param_name' => 'exclude_posts',
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),       
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Include Testomionials', 'workscout' ),
        'param_name' => 'include_posts',
        'settings' => array(
            'multiple' => true,
            'sortable' => true,
          ),
      ),        
      array(
        'type' => 'attach_image',
        'heading' => esc_html__( 'Background Image for Testomionials section', 'workscout' ),
        'param_name' => 'background',
        'value' => '',
        'description' => esc_html__( 'Select image from media library.', 'workscout' )
        ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )
    ),
  ));
}

add_filter( 'vc_autocomplete_testimonials_wide_include_posts_callback',
  'vc_include_testimonials_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_testimonials_wide_include_posts_render',
  'vc_include_testimonials_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_testimonials_wide_exclude_posts_callback',
  'vc_include_testimonials_search', 10, 1 ); // Get suggestion(find). Must return an array

 add_filter( 'vc_autocomplete_testimonials_wide_exclude_posts_render',
  'vc_include_testimonials_render', 10, 1 ); // Render exact product. Must return an array (label,value)



/*
 * [actionbox] 
 *
 */
add_action( 'init', 'ws_actionbox_integrateWithVC' );
function ws_actionbox_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Action Box","workscout"),
    "base" => "actionbox",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows call-to-action box', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout' ),
        'param_name' => 'wide',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout' ) => 'false',
          esc_html__( 'Wide', 'workscout' ) => 'true',
          ),
        'save_always' => true,
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'value' => 'Start Building Your Own Job Board Now ', // default value
        'description' => '',
      ),      
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'URL', 'workscout' ),
        'param_name' => 'url',
        'description' => esc_html__( 'Where button will link.', 'workscout' )
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Button text', 'workscout' ),
        'param_name' => 'buttontext',
        'description' => esc_html__( 'Button text - leave empty to hide button.', 'workscout' )
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )

    ),
  ));
}


/*
 * [centered_headline] 
 *
 */
add_action( 'init', 'ws_centered_headline_integrateWithVC' );
function ws_centered_headline_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Action Box Centered","workscout"),
    "base" => "centered_headline",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows centered version of call-to-action box', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout' ),
        'param_name' => 'wide',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout' ) => 'false',
          esc_html__( 'Wide', 'workscout' ) => 'true',
          ),
        'save_always' => true,
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'value' => 'Start Building Your Own Job Board Now ', // default value
        'description' => '',
      ),      
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Subtitle', 'workscout' ),
        'param_name' => 'subtitle',
        'description' => ''
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'URL', 'workscout' ),
        'param_name' => 'url',
        'description' => esc_html__( 'Where it will link.', 'workscout' )
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )

    ),
  ));
}



add_action( 'init', 'clients_carousel_integrateWithVC' );
function clients_carousel_integrateWithVC() {

  vc_map( array(
    "name" => esc_html__("Client logos carousel", 'workscout'),
    "base" => "vc_clients_carousel",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Carousel with logos', 'workscout' ),
    "category" => esc_html__('WorkScout', 'workscout'),
    "params" => array(
     array(
      'type' => 'attach_images',
      'heading' => esc_html__( 'Clients logos', 'workscout' ),
      'param_name' => 'logos',
      'value' => '',
      'description' => esc_html__( 'Select images from media library.', 'workscout' )
      ),
     array(
      'type' => 'from_vs_indicatior',
      'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
      'param_name' => 'from_vs',
      'value' => 'yes',
      'save_always' => true,
      )
     ),
    ));
}


/*
 * Recent blog posts for Visual Composer
 *
 */

add_action( 'init', 'workscout_recent_blog_integrateWithVC' );
function workscout_recent_blog_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Recent blog posts","workscout"),
    "base" => "latest_from_blog",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Recent posts list', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    /*  'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
    'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),*/
    "params" => array(
      array(
          'type' => 'textfield',
          'heading' => esc_html__( 'Total items', 'workscout' ),
          'param_name' => 'limit',
          'value' => 3, // default value
          'save_always' => true,
          'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'In how many columns will be post displayed', 'workscout' ),
        'param_name' => 'columns',
        'save_always' => true,
        'value' => array('2','3','4'),
        'save_always' => true,
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Masonry mode', 'workscout' ),
        'param_name' => 'masonry',
        'save_always' => true,
        'value' => array(
          esc_html__( 'Disable', 'workscout' ) => 'no',
          esc_html__( 'Enable', 'workscout' ) => 'yes'
          ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
         'save_always' => true,
        'value' => array(
          esc_html__( 'Date', 'workscout' ) => 'date',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Author', 'workscout' ) => 'author',
          esc_html__( 'Title', 'workscout' ) => 'title',
          esc_html__( 'Modified', 'workscout' ) => 'modified',
          esc_html__( 'Random', 'workscout' ) => 'rand',
          esc_html__( 'Comment count', 'workscout' ) => 'comment_count',
          esc_html__( 'Menu order', 'workscout' ) => 'menu_order'
          ),
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
         'save_always' => true,
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
        ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Number of words from content to show below thumbnail', 'workscout' ),
        'param_name' => 'limit_words',
        'description' => esc_html__( 'Type just a number', 'workscout' ),
        'value' => 10,
        'save_always' => true,

      ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Exclude posts, leave empty to not exclude anything', 'workscout' ),
        'param_name' => 'exclude_posts',
        'settings' => array(
          'post_type' => 'post',
          ),
        ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Show only this categories', 'workscout' ),
        'param_name' => 'categories',
        'taxonomy' => 'category',
        ),
      array(
        'type' => 'autocomplete',
        'heading' => esc_html__( 'Show only this tags', 'workscout' ),
        'param_name' => 'tags',
        'taxonomy' => 'post_tag',
        ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
      ),
  ));
}


add_filter( 'vc_autocomplete_latest_from_blog_exclude_posts_callback',
  'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_exclude_posts_render',
  'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_latest_from_blog_categories_callback',
  'ws_categories_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_categories_render',
  'ws_categories_render', 10, 1 ); // Render exact product. Must return an array (label,value)

add_filter( 'vc_autocomplete_latest_from_blog_tags_callback',
  'ws_tags_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_latest_from_blog_tags_render',
  'ws_tags_render', 10, 1 ); // Render exact product. Must return an array (label,value)


add_action( 'init', 'ws_box_job_categories_full_integrateWithVC' );
function ws_box_job_categories_full_integrateWithVC() {
  $box_jobs_categories = array('None' => ' ');

  $job_listing_categories = get_terms( 'job_listing_category', 'orderby=count&hide_empty=0' );
  if ( is_array( $job_listing_categories ) && ! empty( $job_listing_categories ) ) {
    foreach ( $job_listing_categories as $job_listing_category ) {
        $box_jobs_categories[ $job_listing_category->name ] =  esc_attr($job_listing_category->term_id) ;
    }
  }
  vc_map( array(
    "name" => esc_html__("Job categories list","workscout"),
    "base" => "jobs_categories",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Dispays nicely styled list of job categories - use only on full-width page', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(
      /*    
    
        'type' => 'parent',  
       */
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title', 'workscout' )
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Wide version (use only on full-width page in full row', 'workscout' ),
        'param_name' => 'full_width',
        'description' => esc_html__( 'Setting this to wide on page with sidebar or not in the maximum wide container will cause layout break.', 'workscout' ),
        'value' => array(
          esc_html__( 'Standard', 'workscout' ) => 'false',
          esc_html__( 'Wide', 'workscout' ) => 'yes',
          ),
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Hide empty", 'workscout'),
        "param_name" => "hide_empty",
        "value" => array(
         'Hide' => '1',
         'Show' => '0',
          ),
        'save_always' => true,
        "description" => "Hides categories that doesn't have any jobs"
      ),      
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Type ", 'workscout'),
        "param_name" => "type",
        "value" => array(
         'none' => '',
         'Group by parent' => 'group_by_parents' ,
         'Show all categories' => 'all',
          'Show just child categories from selectd parent' => 'parent' ,
          ),
        "description" => ""
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Parent id', 'workscout' ),
        'param_name' => 'parent_id',
        'value' => $box_jobs_categories,
        'dependency' => array(
          'element' => 'type',
          'value' => array( 'parent' ),
        ),
      ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order by', 'workscout' ),
        'param_name' => 'orderby',
        'value' => array(
          esc_html__( 'Name', 'workscout' ) => 'naem',
          esc_html__( 'ID', 'workscout' ) => 'ID',
          esc_html__( 'Count', 'workscout' ) => 'count',
          esc_html__( 'Slug', 'workscout' ) => 'slug',
          esc_html__( 'None', 'workscout' ) => 'none',
          ),
        ),

      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Order', 'workscout' ),
        'param_name' => 'order',
        'value' => array(
          esc_html__( 'Descending', 'workscout' ) => 'DESC',
          esc_html__( 'Ascending', 'workscout' ) => 'ASC'
          ),
      ),
       array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Total items', 'workscout' ),
        'param_name' => 'number',
        'value' => 10, // default value
        'description' => esc_html__( 'Set max limit for items  (limited to 1000).', 'workscout' ),
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
    )
  ));
}



/*
 * Notification Box Visual Composer
 *
 */

add_action( 'init', 'workscout_box_integrateWithVC' );
function workscout_box_integrateWithVC() {

 vc_map( array(
  "name" => esc_html__("Notification box", 'workscout'),
  "base" => "box",
  'icon' => 'workscout_icon',
  "category" => esc_html__('WorkScout', 'workscout'),
  "params" => array(
    array(
      'type' => 'textarea_html',
      'heading' => esc_html__( 'Content', 'workscout' ),
      'param_name' => 'content',
      'description' => esc_html__( 'Enter message content.', 'workscout' )
      ),
    array(
      "type" => "dropdown",
      "class" => "",
      "heading" => esc_html__("Box type", 'workscout'),
      "param_name" => "type",
      'save_always' => true,
      "value" => array(
        'Error' => 'error',
        'Success' => 'success',
        'Warning' => 'warning',
        'Notice' => 'notice',
        ),
      "description" => ""
    )

    ),
/*    'custom_markup' => 'Type: %content% co to kurwa jest',
    'js_view' => 'VcWorkScoutMessageView'*/
));
}


/*
 * [actionbox] 
 *
 */
add_action( 'init', 'ws_workscout_info_banner_integrateWithVC' );
function ws_workscout_info_banner_integrateWithVC() {
  $target_arr = array(
    esc_html__( 'Same window', 'workscout' ) => '_self',
    esc_html__( 'New window', 'workscout' ) => '_blank'
  );
  vc_map( array(
    "name" => esc_html__("Info Banner","workscout"),
    "base" => "infobanner",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Shows call-to-action box', 'workscout' ),
    "category" => esc_html__('WorkScout',"workscout"),
    "params" => array(

      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'value' => 'Start Building Your Own Job Board Now ', // default value
        'description' => '',
      ),      
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'URL', 'workscout' ),
        'param_name' => 'url',
        'description' => esc_html__( 'Where button will link.', 'workscout' )
      ),
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Button text', 'workscout' ),
        'param_name' => 'buttontext',
        'description' => esc_html__( 'Button text - leave empty to hide button.', 'workscout' )
      ),
      array(
        "type" => "dropdown",
        "class" => "",
        "heading" => esc_html__("Link target", 'workscout'),
        "param_name" => "type",
        "value" => $target_arr,
        "description" => ""
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
      )

    ),
  ));
}


/*
 * Counter for Visual Composer
 *
 */

add_action( 'init', 'workscout_counterbox_integrateWithVC' );
function workscout_counterbox_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Counters wraper", "workscout"),
    "base" => "counters",
    "as_parent" => array('only' => 'counter'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "category" => esc_html__('WorkScout', 'workscout'),
    'icon' => 'workscout_icon',
    "show_settings_on_create" => false,
    "params" => array(
        // add params same as with any other content element
      array(
        "type" => "textfield",
        "heading" => esc_html__("Extra class name", "workscout"),
        "param_name" => "el_class",
        "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "workscout")
        ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
      ),
    "js_view" => 'VcColumnView'
    ));
  vc_map( array(
    "name" => esc_html__("Count up box", 'workscout'),
    "base" => "counter",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Box with animated number\'s counting', 'workscout' ),
    "category" => esc_html__('WorkScout', 'workscout'),
    "params" => array(
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Title', 'workscout' ),
        'param_name' => 'title',
        'description' => esc_html__( 'Enter text which will be used as title.', 'workscout' )
        ),
      
      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Value', 'workscout' ),
        'param_name' => 'number',
        'description' => esc_html__( 'Only number (for example 2,147).', 'workscout' )
        ),      

      array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Scale', 'workscout' ),
        'param_name' => 'value',
        'description' => esc_html__( 'Optional. For example %, degrees, k, etc.', 'workscout' )
        ),
      array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Width of the box', 'workscout' ),
        'param_name' => 'width',
        'description' => esc_html__( 'Applicable if the element is a child of "counters" element', 'workscout' ),
        'value' => array(
          esc_html__('One-third','workscout') => 'one-third',
          esc_html__('Two','workscout') => 'two',
          esc_html__('Three','workscout') => 'three',
          esc_html__('Four','workscout') => 'four',
          ),
        'save_always' => true,
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
      ),
));
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Counters extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Counter extends WPBakeryShortCode {
    }
}


/*
 * WooCommerce Products list for Visual Composer
 *
 */

add_action( 'init', 'workscout_pricing_table_integrateWithVC' );
function workscout_pricing_table_integrateWithVC() {
  vc_map( array(
    "name" => esc_html__("Pricing table", 'workscout'),
    "base" => "pricing_table",
    'icon' => 'workscout_icon',
    'description' => esc_html__( 'Pricing table', 'workscout' ),
    "category" => esc_html__('WorkScout', 'workscout'),
    "params" => array(
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Type of table', 'workscout' ),
        'param_name' => 'type',
        'value' => array(
          esc_html__('Standard','workscout') => 'color-1',
          esc_html__('Featured','workscout') => 'color-2',
          ),
        ),
    array(
      'type' => 'colorpicker',
      'heading' => esc_html__( 'Custom color', 'workscout' ),
      'param_name' => 'color',
      'description' => esc_html__( 'Select custom background color for table.', 'workscout' ),
      //'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
    ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Title', 'workscout' ),
      'param_name' => 'title',
      'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'workscout' ),
      'save_always' => true,
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Currency', 'workscout' ),
      'param_name' => 'currency',
      'value' => '$',
      'save_always' => true,
      'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'workscout' )
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Price', 'workscout' ),
      'param_name' => 'price',
      'value' => '30',
      'save_always' => true,
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Per', 'workscout' ),
      'param_name' => 'per',
      'value' => 'per month',
      'save_always' => true,
      ),
      array(
      'type' => 'textarea_html',
      'heading' => esc_html__( 'Content', 'workscout' ),
      'param_name' => 'content',
      'description' => esc_html__( 'Put here simple UL list', 'workscout' )
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Button URL', 'workscout' ),
      'param_name' => 'buttonlink',
      'value' => ''
      ),
    array(
      'type' => 'textfield',
      'heading' => esc_html__( 'Button text', 'workscout' ),
      'param_name' => 'buttontext',
      'value' => ''
      ),
      array(
        'type' => 'from_vs_indicatior',
        'heading' => esc_html__( 'From Visual Composer', 'workscout' ),
        'param_name' => 'from_vs',
        'value' => 'yes',
        'save_always' => true,
        )
      ),
));
}


/*helpers*/

 $job_listing_categories = get_terms( 'job_listing_category', 'orderby=count&hide_empty=0' );
  if ( is_array( $job_listing_categories ) && ! empty( $job_listing_categories ) ) {
    foreach ( $job_listing_categories as $job_listing_category ) {
        $box_jobs_categories[ $job_listing_category->name ] =  esc_attr($job_listing_category->term_id) ;
    }
  }


/**
 * @param $search_string
 *
 * @return array
 */
function vc_include_job_categories_search( $search_string ) {

  $data = array();

  $terms = get_terms( 'job_listing_category',  array(
    'hide_empty' => false,
    'search' => $search_string
  ) );
  if ( is_array( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $data[] = array(
        'value' => $term->term_id,
        'label' => $term->name,
      );
    }
  }

  return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function vc_include_job_categories_render( $value ) {
  $term = get_term( $value['value'],'job_listing_category' );

  return is_null( $term ) ? false : array(
    'label' => $term->name,
    'value' => $term->term_id,
  );
}




/**
 * @param $search_string
 *
 * @return array
 */
function ws_categories_search( $search_string ) {

  $data = array();

  $terms = get_terms( 'category',  array(
    'hide_empty' => false,
    'search' => $search_string
  ) );
  if ( is_array( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $data[] = array(
        'value' => $term->term_id,
        'label' => $term->name,
      );
    }
  }

  return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function ws_categories_render( $value ) {
  $term = get_term( $value['value'],'category' );

  return is_null( $term ) ? false : array(
    'label' => $term->name,
    'value' => $term->term_id,
  );
}

/**
 * @param $search_string
 *
 * @return array
 */
function ws_tags_search( $search_string ) {

  $data = array();

  $terms = get_terms( 'post_tag',  array(
    'hide_empty' => false,
    'search' => $search_string
  ) );
  if ( is_array( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $data[] = array(
        'value' => $term->term_id,
        'label' => $term->name,
      );
    }
  }

  return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function ws_tags_render( $value ) {
  $term = get_term( $value['value'],'post_tag' );

  return is_null( $term ) ? false : array(
    'label' => $term->name,
    'value' => $term->term_id,
  );
}





/**
 * @param $search_string
 *
 * @return array
 */
function vc_include_job_types_search( $search_string ) {

  $data = array();

  $terms = get_terms( 'job_listing_type',  array(
    'hide_empty' => false,
    'search' => $search_string
  ) );
  if ( is_array( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $data[] = array(
        'value' => $term->term_id,
        'label' => $term->name,
      );
    }
  }

  return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function vc_include_job_types_render( $value ) {
  $term = get_term( $value['value'],'job_listing_type' );

  return is_null( $term ) ? false : array(
    'label' => $term->name,
    'value' => $term->term_id,
  );
}





/**
 * @param $search_string
 *
 * @return array
 */
function vc_include_testimonials_search( $search_string ) {
  $query = $search_string;
  $data = array();
  $args = array( 's' => $query, 'post_type' => 'testimonial' );
  $args['vc_search_by_title_only'] = true;
  $args['numberposts'] = - 1;
  if ( strlen( $args['s'] ) === 0 ) {
    unset( $args['s'] );
  }
  add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
  $posts = get_posts( $args );
  if ( is_array( $posts ) && ! empty( $posts ) ) {
    foreach ( $posts as $post ) {
      $data[] = array(
        'value' => $post->ID,
        'label' => $post->post_title,
        'group' => $post->post_type,
      );
    }
  }

  return $data;
}

/**
 * @param $value
 *
 * @return array|bool
 */
function vc_include_testimonials_render( $value ) {
  $post = get_post( $value['value'] );

  return is_null( $post ) ? false : array(
    'label' => $post->post_title,
    'value' => $post->ID,
    'group' => $post->post_type
  );
}


function from_vs_indicatior_settings_field($settings, $value) {
  //$dependency = vc_generate_dependencies_attributes($settings);
  return '<div class="from_vs_indicatior_block" >'
  .'<input type="hidden" name="from_vs" class="wpb_vc_param_value wpb-checkboxes '.$settings['param_name'].' '.$settings['type'].'_field" value="yes"  /></div>';
}

vc_add_shortcode_param('from_vs_indicatior', 'from_vs_indicatior_settings_field');
?>

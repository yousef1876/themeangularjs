<?php 

function workscout_job_manager_output_jobs_defaults( $defaults ) {
        $job_page = get_option('job_manager_jobs_page_id');
		if(!empty($job_page) && is_page($job_page)){
        	$defaults[ 'show_filters' ] = false;
        }
        return $defaults;
    }
add_filter( 'job_manager_output_jobs_defaults','workscout_job_manager_output_jobs_defaults');


/*
 * adding rate | hours | salary fields for jobs edit/submit
 */
add_filter( 'submit_job_form_fields', 'workscout_frontend_add_rate_field' );
function workscout_frontend_add_rate_field( $fields ) {
  $currency = get_workscout_currency_symbol();
  $fields['job']['rate_min'] = array(
    'label'       => esc_html__( 'Minimum rate/h', 'workscout' ).' ('.$currency.')',
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'e.g. 20',
    'priority'    => 7
  );  
  $fields['job']['rate_max'] = array(
    'label'       => esc_html__( 'Maximum rate/h', 'workscout' ).' ('.$currency.')',
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'e.g. 50',
    'priority'    => 8
  );
  $fields['job']['salary_min'] = array(
    'label'       => esc_html__( 'Minimum Salary', 'workscout' ).' ('.$currency.')',
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'e.g. 20000',
    'priority'    => 9
  );  
  $fields['job']['salary_max'] = array(
    'label'       => esc_html__( 'Maximum Salary', 'workscout' ).' ('.$currency.')',
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'e.g. 50000',
    'priority'    => 10
  );
  $fields['job']['hours'] = array(
    'label'       => esc_html__( 'Hours per week', 'workscout' ),
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'e.g. 72',
    'priority'    => 11
  );
  $fields['job']['apply_link'] = array(
    'label'       => esc_html__( 'External "Apply for Job" link', 'workscout' ),
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'http://',
    'priority'    => 12
  );    
  
/*  $fields['job']['hide_expiration'] = array(
    'label'       => esc_html__( 'Hide "Expiration date"', 'workscout' ),
    'type'        => 'checkbox',
    'required'    => false,
    'std'		  => 0,
    'priority'    => 13
  );*/
  return $fields;
}


/**
 * Save the extra frontend fields
 *
 * @since WorkScout 1.0.2
 *
 * @return void
 */
function workscout_job_manager_update_job_data( $job_id, $values ) {
	update_post_meta( $job_id, '_rate_min', $values[ 'job' ][ 'rate_min' ] );
	update_post_meta( $job_id, '_rate_max', $values[ 'job' ][ 'rate_max' ] );
	update_post_meta( $job_id, '_salary_min', $values[ 'job' ][ 'salary_min' ] );
	update_post_meta( $job_id, '_salary_max', $values[ 'job' ][ 'salary_max' ] );
	update_post_meta( $job_id, '_hours', $values[ 'job' ][ 'hours' ] );
	update_post_meta( $job_id, '_apply_link', $values[ 'job' ][ 'apply_link' ] );
	//update_post_meta( $job_id, '_hide_expiration', $values[ 'job' ][ 'hide_expiration' ] );
	
}
add_action( 'job_manager_update_job_data', 'workscout_job_manager_update_job_data', 10, 2 );


/* Add rate rate | hours | salary fields for job listing*/
add_filter( 'job_manager_job_listing_data_fields', 'workscout_admin_add_rate_field' );

function workscout_admin_add_rate_field( $fields ) {
	$currency = get_workscout_currency_symbol();
	$fields['_hours'] = array(
	    'label'       => esc_html__( 'Hours per week', 'workscout' ),
	    'type'        => 'text',
	    'placeholder' => 'e.g. 72',
	    'description' => ''
  	);
	$fields['_rate_min'] = array(
	    'label'       => esc_html__( 'Rate/h (minimum)', 'workscout' ),
	    'type'        => 'text',
	    'placeholder' => 'e.g. 20',
	    'description' => esc_html__('Put just a number','workscout'),
	);    
	$fields['_rate_max'] = array(
	    'label'       => esc_html__( 'Rate/h (maximum) ', 'workscout' ),
	    'type'        => 'text',
	    'placeholder' => esc_html__('e.g. 20','workscout'),
	    'description' => esc_html__('Put just a number - you can leave it empty and set only minimum rate value ','workscout'),
	);  
	$fields['_salary_min'] = array(
	    'label'       => esc_html__( 'Salary min', 'workscout' ).' ('.$currency.')',
	    'type'        => 'text',
	    'placeholder' => esc_html__('e.g. 20.000','workscout'),
	    'description' => esc_html__('Put just a number','workscout'),
	);   
	$fields['_salary_max'] = array(
	    'label'       => esc_html__( 'Salary max', 'workscout' ).' ('.$currency.')',
	    'type'        => 'text',
	    'placeholder' => esc_html__('e.g. 50.000','workscout'),
	    'description' => esc_html__('Maximum of salary range you can offer - you can leave it empty and set only minimum salary ','workscout'),
  	); 	
  	$fields['_apply_link'] = array(
	    'label'       => esc_html__( 'External "Apply for Job" link', 'workscout' ),
	    'type'        => 'text',
	    'placeholder' => esc_html__('http://','workscout'),
	    'description' => esc_html__('If the job applying is done on external page, here\'s the place to put link to that page - it will be used instead of standard Apply form','workscout'),
  	);   	
  	$fields['_hide_expiration'] = array(
	    'label'       => esc_html__( 'Hide "Expiration date"', 'workscout' ),
	    'type'        => 'checkbox',
	    'std' 		  => 0,
	    'priority'    => 12,
	    'description' => esc_html__('Hide the Listing Expiry Date  from job details','workscout'),
  	); 
 

  return $fields;
}



add_filter( 'job_manager_get_listings', 'workscout_filter_by_company', 10, 2 );

function workscout_filter_by_company( $query_args, $args ) {
	if ( get_query_var( 'company' ) ) {
		// If this is set, we are filtering by salary
	 	$query_args['meta_query'] = array(
		 	array(
                'key'   => '_company_name',
                'value' => urldecode( get_query_var( 'company') )
            )
        );
	}
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );
		if( isset( $form_data['company_field']) ) {
			$query_args['meta_query'] = array(
			 	array(
	                'key'   => '_company_name',
	                'value' => $form_data['company_field']
	            )
	        );
		}
	}
	return $query_args;

}
/**
 * This code gets your posted field and modifies the job search query
 */
add_filter( 'job_manager_get_listings', 'workscout_filter_by_salary_field_query_args', 10, 2 );

function workscout_filter_by_salary_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );

		// If this is set, we are filtering by salary
		if( isset( $form_data['filter_by_salary_check']) ) {
			if ( ! empty( $form_data['filter_by_salary'] ) ) {
				$selected_range = sanitize_text_field( $form_data['filter_by_salary'] );
			
					$range = array_map( 'absint', explode( '-', $selected_range ) );
				 	$query_args['meta_query'] = array(
					 	'relation' => 'OR',
					        array(
					            'relation' => 'OR',
					            array(
	                                'key' => '_salary_min',
	                                'value' => $range,
	                                'compare' => 'BETWEEN',
	                                'type' => 'NUMERIC',
	                            ),
	                            array(
	                                'key' => '_salary_max',
	                                'value' => $range,
	                                'compare' => 'BETWEEN',
	                                'type' => 'NUMERIC',
	                            ),
					 
					        ),
					        array(
					            'relation' => 'AND',
					            array(
	                                'key' => '_salary_min',
	                                'value' => $range[0],
	                                'compare' => '<=',
	                                'type' => 'NUMERIC',
	                            ),
	                            array(
	                                'key' => '_salary_max',
	                                'value' => $range[1],
	                                'compare' => '>=',
	                                'type' => 'NUMERIC',
	                            ),
					 
					        ),
			        );
				// This will show the 'reset' link
				add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			}
		} else {
			add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
		}
	}
	return $query_args;

}


/**
 * This code gets your posted field and modifies the job search query
 */
add_filter( 'job_manager_get_listings', 'workscout_filter_by_rate_field_query_args', 10, 2 );

function workscout_filter_by_rate_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );

		// If this is set, we are filtering by salary
		if( isset( $form_data['filter_by_rate_check'])) {
			if ( ! empty( $form_data['filter_by_rate'] ) ) {
				$selected_range = sanitize_text_field( $form_data['filter_by_rate'] );
			
					$range = array_map( 'absint', explode( '-', $selected_range ) );
				 	$query_args['meta_query'] = array(
					 	'relation' => 'OR',
					        array(
					            'relation' => 'OR',
					            array(
	                                'key' => '_rate_min',
	                                'value' => $range,
	                                'compare' => 'BETWEEN',
	                                'type' => 'NUMERIC',
	                            ),
	                            array(
	                                'key' => '_rate_max',
	                                'value' => $range,
	                                'compare' => 'BETWEEN',
	                                'type' => 'NUMERIC',
	                            ),
					 
					        ),
					        array(
					            'relation' => 'AND',
					            array(
	                                'key' => '_rate_min',
	                                'value' => $range[0],
	                                'compare' => '<=',
	                                'type' => 'NUMERIC',
	                            ),
	                            array(
	                                'key' => '_rate_max',
	                                'value' => $range[1],
	                                'compare' => '>=',
	                                'type' => 'NUMERIC',
	                            ),
					 
					        ),
			        );
			

				// This will show the 'reset' link
				add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			}
		}
	}
	return $query_args;

}





/* Resumes related code*/


/*
 * adding rate field for jobs edit/submit
 */
add_filter( 'submit_resume_form_fields', 'workscout_frontend_add_resume_rate_field' );
function workscout_frontend_add_resume_rate_field( $fields ) {
	$currency = get_workscout_currency_symbol();
	  $fields['resume_fields']['candidate_rate_min'] = array(
	    'label'       => esc_html__( 'Minimum rate/h', 'workscout' ).' ('.$currency.')',
	    'type'        => 'text',
	    'required'    => false,
	    'placeholder' => 'e.g. 20',
	    'priority'    => 7
	  );  
	  return $fields;
}


add_filter( 'resume_manager_resume_fields', 'workscout_admin_add_resume_rate_field' );

function workscout_admin_add_resume_rate_field( $fields ) {
	$currency = get_workscout_currency_symbol();
	$fields['_rate_min'] = array(
	    'label'       => esc_html__( 'Rate/h (minimum)', 'workscout' ).' ('.$currency.')',
	    'type'        => 'text',
	    'placeholder' => 'e.g. 20',
	    'description' => 'Put just a number'
	);    
  return $fields;
}



/**
 * This code gets your posted field and modifies the job search query
 */
add_filter( 'resume_manager_get_resumes', 'workscout_resume_filter_by_rate_field_query_args', 10, 2 );

function workscout_resume_filter_by_rate_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );

		// If this is set, we are filtering by salary
		if( isset( $form_data['filter_by_rate_check'])) {
			if ( ! empty( $form_data['filter_by_rate'] ) ) {
				$selected_range = sanitize_text_field( $form_data['filter_by_rate'] );
			
				 	$query_args['meta_query'][] = array(
						'key'     => '_rate_min',
						'value'   => array_map( 'absint', explode( '-', $selected_range ) ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC'
					);
			

				// This will show the 'reset' link
				add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
			}
		}
	}
	return $query_args;

}


/**
 * This code gets your posted field and modifies the resume search query
 */
add_filter( 'resume_manager_get_resumes', 'workscout_filter_by_skills_field_query_args', 10, 2 );

function workscout_filter_by_skills_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );

		// If this is set, we are filtering by salary
		if( isset( $form_data['search_skills'])) {
			if ( ! empty( $form_data['search_skills'] ) ) {
					
					$field    = is_numeric( $form_data['search_skills'][0] ) ? 'term_id' : 'slug';
					$operator = 'all' === sizeof( $form_data['search_skills'] ) > 1 ? 'AND' : 'IN';
		
					$query_args['tax_query'][] = array(
						'taxonomy'         => 'resume_skill',
						'field'            => $field,
						'terms'            => array_values( $form_data['search_skills'] ),
						'include_children' => $operator !== 'AND' ,
						'operator'         => $operator
					);
				// This will show the 'reset' link
				add_filter( 'resume_manager_get_resumes_custom_filter', '__return_true' );
				
			}
		}
	}
	return $query_args;

}

/*
 * Custom Icon field for Job Categories taxonomy 
 **/

// Add term page
function workscout_job_listing_category_add_new_meta_field() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="term_meta[fa_icon]"><?php esc_html_e( 'Font awesome icon for category', 'workscout' ); ?></label>
			<select name="term_meta[fa_icon]" id="term_meta[fa_icon]" id="">
			<option value="">-no icon-</option>
			<?php 
			 	$faicons = workscout_icons_list();
			   	foreach ($faicons as $key => $value) {
			   		echo '<option value="'.$key.'">'.$value.'</option>';
			   	}
			   ?>

			</select>
		<p class="description"><?php esc_html_e( 'Icon will be displayed in categories grid view','workscout' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[upload_icon]"><?php esc_html_e( 'Custom image icon for category', 'workscout' ); ?></label>
		<input type="text" name="term_meta[upload_icon]" id="term_meta[upload_icon]" value="">
		<p class="description"><?php esc_html_e( 'This is alternative for FontAwesome icons','workscout' ); ?></p>
	</div>	
	<div class="form-field">
		<label for="term_meta[upload_icon]"><?php esc_html_e( 'Background image for category header', 'workscout' ); ?></label>
		<input type="text" name="term_meta[upload_header]" id="term_meta[upload_header]" value="">
		<p class="description"><?php esc_html_e( 'Similar to the single jobs you can add image to the category header. It should be 1920px wide','workscout' ); ?></p>
	</div>

	
		
<?php
}
add_action( 'job_listing_category_add_form_fields', 'workscout_job_listing_category_add_new_meta_field', 10, 2 );


// Edit term page
function workscout_job_listing_category_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" ); 
	 ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[fa_icon]"><?php esc_html_e( 'Font awesome icon for category', 'workscout' ); ?></label></th>
		<td>
			<select name="term_meta[fa_icon]" id="term_meta[fa_icon]">
				<option value="">-no icon-</option>
			<?php 
			 	$faicons = workscout_icons_list();
			   	foreach ($faicons as $key => $value) {
			   		echo '<option value="'.$key.'" ';
			   		if($term_meta['fa_icon'] == $key) { echo ' selected="selected"';}
			   		echo '>'.$value.'</option>';
			   	}
			   ?>

			</select>
			<p class="description"><?php esc_html_e( 'Icon will be displayed in categories grid view','workscout' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[upload_icon]"><?php esc_html_e( 'Custom image icon for category', 'workscout' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[upload_icon]" id="term_meta[upload_icon]" value="<?php echo esc_attr( $term_meta['upload_icon'] ) ? esc_attr( $term_meta['upload_icon'] ) : ''; ?>">
			<p class="description"><?php esc_html_e( 'This is alternative for FontAwesome icons','workscout' ); ?></p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[upload_header]"><?php esc_html_e( 'Background image for category header', 'workscout' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[upload_header]" id="term_meta[upload_header]" value="<?php echo esc_attr( $term_meta['upload_header'] ) ? esc_attr( $term_meta['upload_header'] ) : ''; ?>">
			<p class="description"><?php esc_html_e( 'Similar to the single jobs you can add image to the category header. Put here direct link to the image. It should be 1920px wide','workscout' ); ?></p>
		</td>
	</tr>
<?php
}
add_action( 'job_listing_category_edit_form_fields', 'workscout_job_listing_category_edit_meta_field', 10, 2 );


// Save extra taxonomy fields callback function.
function workscout_save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_job_listing_category', 'workscout_save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_job_listing_category', 'workscout_save_taxonomy_custom_meta', 10, 2 );

remove_shortcode('jobs');
remove_shortcode('resumes');

function workscout_manage_table_icons($val){
	switch ($val) {
		
		case 'resume-title':
			$icon = '<i class="fa fa-user"></i> ';
			break;
		case 'candidate-title':
		case 'job_title':
			$icon = '<i class="fa fa-file-text"></i> ';
			break;
		case 'filled':
			$icon = '<i class="fa fa-check-square-o"></i> ';
			break;
		case 'date':
			$icon = '<i class="fa fa-calendar"></i> ';
			break;
		case 'expires':
			$icon = '<i class="fa fa-calendar"></i> ';
			break;
		case 'candidate-location':
			$icon = '<i class="fa fa-map-marker"></i> ';
			break;
		
		default:
			$icon = '';
			break;
	}
	return $icon;
}

function workscout_manage_action_icons($val){
	switch ($val) {
		
		case 'view':
			$icon = '<i class="fa fa-check-circle-o"></i> ';
			break;	
		case 'email':
			$icon = '<i class="fa fa-envelope"></i> ';
			break;		
		case 'toggle_status':
			$icon = '<i class="fa fa-eye-slash"></i> ';
			break;
		case 'delete':
			$icon = '<i class="fa fa-remove"></i> ';
			break;
		case 'hide':
			$icon = '<i class="fa fa-eye-slash"></i> ';
			break;
		case 'edit':
			$icon = '<i class="fa fa-pencil"></i> ';
			break;
		case 'mark_filled':
			$icon = '<i class="fa  fa-check "></i> ';
			break;		
		case 'publish':
			$icon = '<i class="fa  fa-eye "></i> ';
			break;

		case 'mark_not_filled':
			$icon = '<i class="fa  fa-minus "></i> ';
			break;
		default:
			$icon = '';
			break;
	}
	return $icon;
}


/* sending user to sign up to Login page if exists */
add_filter( 'submit_job_form_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_job_dashboard_login_url', 'workscout_custom_login_url' );
add_filter( 'submit_resume_form_login_url', 'workscout_custom_login_url' );
add_filter( 'resume_manager_candidate_dashboard_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_alerts_login_url', 'workscout_custom_login_url' );
add_filter( 'job_manager_bookmark_form_login_url', 'workscout_custom_login_url' );

 
function workscout_custom_login_url() {
	$loginpage = ot_get_option('pp_login_page');
	if( ! empty( $loginpage )) {
	    return get_permalink($loginpage);
	}
    else {
    	return wp_login_url( get_permalink() );
    }
}
	
/*remove bookmarks link*/
if ( class_exists( 'WP_Job_Manager_Bookmarks' ) ) {
	global $job_manager_bookmarks;
	remove_action( 'single_job_listing_meta_after', array( $job_manager_bookmarks, 'bookmark_form' ) );
	remove_action( 'single_resume_start', array( $job_manager_bookmarks, 'bookmark_form' ) );

	add_action( 'workscout_bookmark_hook', array( $job_manager_bookmarks, 'bookmark_form' ) );
	add_action( 'workscout_bookmark_hook', array( $job_manager_bookmarks, 'bookmark_form' ) );
}

/* register with role */

add_action( 'register_form', 'workscout_register_form' );
function workscout_register_form() {

    global $wp_roles;
    echo '<label for="user_email">'.esc_html__('I\'m looking..','workscout').'</label>';
    echo '<select name="role" class="input chosen-select">';
    echo '<option value="employer">'.esc_html__("..to hire","workscout").'</option>';
    echo '<option value="candidate">'.esc_html__(".. for a job","workscout").'</option>';
    echo '</select>';
}


//2. Add validation.
add_filter( 'registration_errors', 'workscout_registration_errors', 10, 3 );
function workscout_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['role'] ) || ! empty( $_POST['role'] ) && trim( $_POST['role'] ) == '' ) {
         $errors->add( 'role_error', esc_html__( '<strong>ERROR</strong>: You must include a role.', 'workscout' ) );
    }

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action( 'user_register', 'workscout_user_register' );
function workscout_user_register( $user_id ) {
	if(isset($_POST['role'])){
   		$user_id = wp_update_user( array( 'ID' => $user_id, 'role' => $_POST['role'] ) );
   	}
}


function workscout_get_rating_class($average) {
	if(!$average) {
			$class="no-stars";
	} else {
		switch ($average) {
			
			case $average >= 1 && $average < 1.5:
				$class="one-stars";
				break;
			case $average >= 1.5 && $average < 2:
				$class="one-and-half-stars";
				break;
			case $average >= 2 && $average < 2.5:
				$class="two-stars";
				break;
			case $average >= 2.5 && $average < 3:
				$class="two-and-half-stars";
				break;
			case $average >= 3 && $average < 3.5:
				$class="three-stars";
				break;
			case $average >= 3.5 && $average < 4:
				$class="three-and-half-stars";
				break;
			case $average >= 4 && $average < 4.5:
				$class="four-stars";
				break;
			case $average >= 4.5 && $average < 5:
				$class="four-and-half-stars";
				break;
			case $average >= 5:
				$class="five-stars";
				break;

			default:
				$class="no-stars";
				break;
		}
	}
	return $class;
	}

function get_workscout_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = get_option('workscout_currency_setting');
	}

	switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'د.إ';
			break;
		case 'AUD' :
		case 'ARS' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		case 'MXN' :
		case 'NZD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
			$currency_symbol = '&yen;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'DKK' :
			$currency_symbol = 'DKK';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'INR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		default :
			$currency_symbol = '';
			break;
	}

	return apply_filters( 'woocommerce_currency_symbol', $currency_symbol, $currency );
}
/*
 * Adds Settings for Job Manager Options
 */
add_filter( 'job_manager_settings', 'workscout_job_manager_settings' );

function workscout_job_manager_settings($settings = array()){
	$settings['job_listings'][1][] = array(
		'name'    => 'workscout_currency_setting',
		'std'     => 'USD',
		'label'   => 'Currency Symbol',
		'desc'    => 'Select the currency symbol that will be used in salary/rate fields',
		'type'    => 'select',
		'options' => array(
			'USD' => esc_html__( 'US Dollars', 'workscout' ),
			'AED' => esc_html__( 'United Arab Emirates Dirham', 'workscout' ),
			'ARS' => esc_html__( 'Argentine Peso', 'workscout' ),
			'AUD' => esc_html__( 'Australian Dollars', 'workscout' ),
			'BDT' => esc_html__( 'Bangladeshi Taka', 'workscout' ),
			'BRL' => esc_html__( 'Brazilian Real', 'workscout' ),
			'BGN' => esc_html__( 'Bulgarian Lev', 'workscout' ),
			'CAD' => esc_html__( 'Canadian Dollars', 'workscout' ),
			'CLP' => esc_html__( 'Chilean Peso', 'workscout' ),
			'CNY' => esc_html__( 'Chinese Yuan', 'workscout' ),
			'COP' => esc_html__( 'Colombian Peso', 'workscout' ),
			'CZK' => esc_html__( 'Czech Koruna', 'workscout' ),
			'DKK' => esc_html__( 'Danish Krone', 'workscout' ),
			'DOP' => esc_html__( 'Dominican Peso', 'workscout' ),
			'EUR' => esc_html__( 'Euros', 'workscout' ),
			'HKD' => esc_html__( 'Hong Kong Dollar', 'workscout' ),
			'HRK' => esc_html__( 'Croatia kuna', 'workscout' ),
			'HUF' => esc_html__( 'Hungarian Forint', 'workscout' ),
			'ISK' => esc_html__( 'Icelandic krona', 'workscout' ),
			'IDR' => esc_html__( 'Indonesia Rupiah', 'workscout' ),
			'INR' => esc_html__( 'Indian Rupee', 'workscout' ),
			'NPR' => esc_html__( 'Nepali Rupee', 'workscout' ),
			'ILS' => esc_html__( 'Israeli Shekel', 'workscout' ),
			'JPY' => esc_html__( 'Japanese Yen', 'workscout' ),
			'KIP' => esc_html__( 'Lao Kip', 'workscout' ),
			'KRW' => esc_html__( 'South Korean Won', 'workscout' ),
			'MYR' => esc_html__( 'Malaysian Ringgits', 'workscout' ),
			'MXN' => esc_html__( 'Mexican Peso', 'workscout' ),
			'NGN' => esc_html__( 'Nigerian Naira', 'workscout' ),
			'NOK' => esc_html__( 'Norwegian Krone', 'workscout' ),
			'NZD' => esc_html__( 'New Zealand Dollar', 'workscout' ),
			'PYG' => esc_html__( 'Paraguayan Guaraní', 'workscout' ),
			'PHP' => esc_html__( 'Philippine Pesos', 'workscout' ),
			'PLN' => esc_html__( 'Polish Zloty', 'workscout' ),
			'GBP' => esc_html__( 'Pounds Sterling', 'workscout' ),
			'RON' => esc_html__( 'Romanian Leu', 'workscout' ),
			'RUB' => esc_html__( 'Russian Ruble', 'workscout' ),
			'SGD' => esc_html__( 'Singapore Dollar', 'workscout' ),
			'ZAR' => esc_html__( 'South African rand', 'workscout' ),
			'SEK' => esc_html__( 'Swedish Krona', 'workscout' ),
			'CHF' => esc_html__( 'Swiss Franc', 'workscout' ),
			'TWD' => esc_html__( 'Taiwan New Dollars', 'workscout' ),
			'THB' => esc_html__( 'Thai Baht', 'workscout' ),
			'TRY' => esc_html__( 'Turkish Lira', 'workscout' ),
			'UAH' => esc_html__( 'Ukrainian Hryvnia', 'workscout' ),
			'USD' => esc_html__( 'US Dollars', 'workscout' ),
			'VND' => esc_html__( 'Vietnamese Dong', 'workscout' ),
			'EGP' => esc_html__( 'Egyptian Pound', 'workscout' )
		)
	);
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_filter_salary',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Filter jobs by Salary', 'workscout' ),
			'cb_label'  => esc_html__( 'Enable filter option on Jobs page', 'workscout' ),
			'desc'		=> esc_html__( 'Enabling this option will show a salary range filter in sidebar on Jobs page.', 'workscout' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_filter_rate',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Filter jobs by Rate', 'workscout' ),
			'cb_label'  => esc_html__( 'Enable filter option on Jobs page', 'workscout' ),
			'desc'		=> esc_html__( 'Enabling this option will show a rate range filter in sidebar on Jobs page.', 'workscout' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_add_job_button',
			'std' 		=> '1',
			'label' 	=> esc_html__( '"Post a job" button on Jobs page', 'workscout' ),
			'cb_label'  => esc_html__( 'Show "Post a job" button on Jobs page', 'workscout' ),
			'desc'		=> esc_html__( 'Uncheck to hide "Post a job" button on Jobs page.', 'workscout' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_location_sidebar',
			'std' 		=> '1',
			'label' 	=> esc_html__( 'Location field on Jobs page', 'workscout' ),
			'cb_label'  => esc_html__( 'Show location search field on Jobs page sidebar', 'workscout' ),
			'desc'		=> esc_html__( 'Uncheck to hide', 'workscout' ),
			'type'      => 'checkbox'
	);	
	$settings['job_listings'][1][] = array(
			'name' 		=> 'workscout_enable_job_types_sidebar',
			'std' 		=> '1',
			'label' 	=> esc_html__( 'Job Types field on Jobs page', 'workscout' ),
			'cb_label'  => esc_html__( 'Show Job Types field on Jobs page sidebar', 'workscout' ),
			'desc'		=> esc_html__( 'Uncheck to hide', 'workscout' ),
			'type'      => 'checkbox'
	);
	return $settings;
}

/*
 * Adds Settings for  Resumes Options
 */
add_filter( 'resume_manager_settings', 'workscout_resume_manager_settings' );

function workscout_resume_manager_settings($settings = array()){
	$settings['resume_listings'][1][] = array(
			'name' 		=> 'workscout_enable_resume_filter_rate',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Filter Resumes by Rate', 'workscout' ),
			'cb_label'  => esc_html__( 'Enable filter option on Resumes page', 'workscout' ),
			'desc'		=> esc_html__( 'Enabling this option will show a salary range filter in sidebar on Resumes page.', 'workscout' ),
			'type'      => 'checkbox'
	);
	$settings['resume_listings'][1][] = array(
			'name' 		=> 'workscout_enable_add_resume_button',
			'std' 		=> '1',
			'label' 	=> esc_html__( '"Post a resume" button on Resumes page', 'workscout' ),
			'cb_label'  => esc_html__( 'Show "Post a job" button on Resumes page', 'workscout' ),
			'desc'		=> esc_html__( 'Uncheck to hide "Post a job" button on Resumes page.', 'workscout' ),
			'type'      => 'checkbox'
	);	
	$settings['resume_listings'][1][] = array(
			'name' 		=> 'workscout_enable_resume_comments',
			'std'        => '0',
			'label' 	=> esc_html__( 'Enable comments on Resumes', 'workscout' ),
			'cb_label'  => esc_html__( 'Enable comments on Resumes', 'workscout' ),
			'desc'		=> esc_html__( 'Check to enable comments section on Resumes.', 'workscout' ),
			'type'      => 'checkbox',
			'attributes' => array()
	);
	return $settings;
}

function workscout_newly_posted() {
	global $post;
	$now = date('U'); $published = get_the_time('U');
	$new = false;
	if( $now-$published  <= 2*24*60*60 ) $new = true;
	return $new;
}


// Add comment support to the post type
add_filter( 'register_post_type_resume', 'register_post_type_resume_enable_comments' );

function register_post_type_resume_enable_comments( $post_type ) {
	$post_type['supports'][] = 'comments';
	return $post_type;
}

// Make comments open by default for new resumes
add_filter( 'submit_resume_form_save_resume_data', 'custom_submit_resume_form_save_resume_data' );

function custom_submit_resume_form_save_resume_data( $data ) {
	$data['comment_status'] = 'open';
	return $data;
}




function custom_job_manager_get_listings_result($result, $jobs) {
	$result['post_count'] = $jobs->found_posts;
	return $result;
}
add_filter( 'job_manager_get_listings_result', 'custom_job_manager_get_listings_result',10,2 );



 function workscout_get_company_link( $company_name ) {
		global $wp_rewrite;
		$slug = apply_filters( 'wp_job_manager_companies_company_slug', __( 'company', 'workscout' ) );
		$company_name = rawurlencode( $company_name );

		if ( $wp_rewrite->permalink_structure == '' ) {
			$url = home_url( 'index.php?'. $slug . '=' . $company_name );
		} else {
			$url = home_url( '/' . $slug . '/' . trailingslashit( $company_name ) );
		}

		return '<a href="'.esc_url( $url ).'">';
	}
?>
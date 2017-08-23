<?php 
/*login */
// user registration login form
function workscout_registration_form() {
 
    // only show the registration form to non-logged-in members
    if(!is_user_logged_in()) {

        // check to make sure user registration is enabled
        $registration_enabled = get_option('users_can_register');
 
        // only show the registration form if allowed
        if($registration_enabled) {
            $output = workscout_registration_form_fields();
        } else {
            $output = __('User registration is not enabled','workscout');
        }
        return $output;
    }
}
add_shortcode('register_form', 'workscout_registration_form');

function workscout_login_form() {
 
    if(!is_user_logged_in()) {
         $output = workscout_login_form_fields();
    } else {
       $output = '';
    }
    return $output;
}
add_shortcode('login_form', 'workscout_login_form');

function workscout_registration_form_fields() {
 
    ob_start(); ?>  
        <div class="entry-header">
            <h3 class="headline margin-bottom-20"><?php esc_html_e('Register','workscout'); ?></h3>
        </div>
 
        <?php 
        // show any error messages after form submission
        workscout_show_error_messages(); ?>
 
        <form id="workscout_registration_form" class="workscout_form" action="" method="POST">
            <p class="status"></p>
            <fieldset>
                <p>
                    <label for="workscout_user_login"><?php _e('Username','workscout'); ?></label>
                    <input name="workscout_user_login" id="workscout_user_login" class="required" type="text"/>
                </p>
                <p>
                    <label for="workscout_user_email"><?php _e('Email','workscout'); ?></label>
                    <input name="workscout_user_email" id="workscout_user_email" class="required" type="email"/>
                </p>
                <p>
                    <label for="password"><?php _e('Password','workscout'); ?></label>
                    <input name="workscout_user_pass" id="password" class="required" type="password"/>
                </p>
                <p>
                    <label for="password_again"><?php _e('Confirm Password','workscout'); ?></label>
                    <input name="workscout_user_pass_confirm" id="password_again" class="required" type="password"/>
                </p>
                <p>
                <?php 
                    echo '<label for="workscout_user_role">'.esc_html__('I\'m looking..','workscout').'</label>';
                    echo '<select name="workscout_user_role" id="workscout_user_role" class="input chosen-select">';
                        echo '<option selected="selected" value="candidate">'.esc_html__(".. for a job","workscout").'</option>';
                        echo '<option value="employer">'.esc_html__("..to hire","workscout").'</option>';
                    echo '</select>';
                ?>
                </p>
                <?php if( function_exists( 'gglcptch_display' ) ) { echo gglcptch_display(); } ; ?>
                <p style="display:none">
                    <label for="confirm_email"><?php esc_html_e('Please leave this field empty','workscout'); ?></label>
                    <input type="text" name="confirm_email" id="confirm_email" class="input" value="">
                </p>
                <p>
                    <input type="hidden" name="workscout_register_nonce" value="<?php echo wp_create_nonce('workscout-register-nonce'); ?>"/>
                    <input type="hidden" name="workscout_register_check" value="1"/>
                    <?php  wp_nonce_field( 'ajax-register-nonce', 'security' );  ?>
                    <input type="submit" value="<?php _e('Register Your Account','workscout'); ?>"/>
                </p>
            </fieldset>
        </form>
    <?php
    return ob_get_clean();
}

function workscout_login_form_fields() {
 
    ob_start(); ?>
        <div class="entry-header">
            <h3 class="headline margin-bottom-20"><?php esc_html_e('Login','workscout'); ?></h3>
        </div>
        <?php  $loginpage = ot_get_option('pp_login_page');  ?>

        <?php
        // show any error messages after form submission
        workscout_show_error_messages(); ?>
 
        <form id="workscout_login_form"  class="workscout_form" action="" method="post">
            <p class="status"></p>
            <fieldset>
                <p>
                    <label for="workscout_user_Login"><?php _e('Username','workscout'); ?></label>
                    <input name="workscout_user_login" id="workscout_user_login" class="required" type="text"/>
                </p>
                <p>
                    <label for="workscout_user_pass"><?php _e('Password','workscout'); ?></label>
                    <input name="workscout_user_pass" id="workscout_user_pass" class="required" type="password"/>
                </p>
                <p>
                    <input type="hidden" id="workscout_login_nonce" name="workscout_login_nonce" value="<?php echo wp_create_nonce('workscout-login-nonce'); ?>"/>
                    <input type="hidden" name="workscout_login_check" value="1"/>
                    <?php  wp_nonce_field( 'ajax-login-nonce', 'security' );  ?>
                    <input id="workscout_login_submit" type="submit" value="Login"/>
                </p>
                <p><?php esc_html_e('Don\'t have an account?','workscout'); ?> <a href="<?php echo get_permalink($loginpage); ?>?action=register"><?php esc_html_e('Sign up now','workscout'); ?></a>!</p>
                                

            </fieldset>
        </form>
    <?php
    return ob_get_clean();
}


// logs a member in after submitting a form
function workscout_login_member() {
 
    if(isset($_POST['workscout_login_check'])  && wp_verify_nonce($_POST['workscout_login_nonce'], 'workscout-login-nonce')) {
 
        // this returns the user ID and other info from the user name
        $user =  get_user_by('login',$_POST['workscout_user_login']);
 
        if(!$user) {
            // if the user name doesn't exist
            workscout_form_errors()->add('empty_username', __('Invalid username','workscout'));

        }
 
        if(!isset($_POST['workscout_user_pass']) || $_POST['workscout_user_pass'] == '') {
            // if no password was entered
            workscout_form_errors()->add('empty_password', __('Please enter a password','workscout'));
        }
 
        if(isset($_POST['workscout_user_pass']) && !empty($_POST['workscout_user_pass'])){
            // check the user's login with their password
            if(!wp_check_password($_POST['workscout_user_pass'], $user->user_pass, $user->ID)) {
                // if the password is incorrect for the specified user
                workscout_form_errors()->add('empty_password', __('Incorrect password','workscout'));
            }
        }
 
        // retrieve all error messages
        $errors = workscout_form_errors()->get_error_messages();
 
        // only log the user in if there are no errors
        if(empty($errors)) {
 
            $creds = array();
            $creds['user_login'] = $_POST['workscout_user_login'];
            $creds['user_password'] = $_POST['workscout_user_pass'];
            $creds['remember'] = true;

            $user = wp_signon( $creds, false );
            // send the newly created user to the home page after logging them in
            if ( is_wp_error($user) ){
                echo $user->get_error_message();
            } else {
                wp_safe_redirect( home_url( '/' ) );
            }
            exit;
        }
    }
}
add_action('init', 'workscout_login_member');



// register a new user
function workscout_add_new_member() {
 
    if (isset( $_POST["workscout_register_check"] ) && wp_verify_nonce($_POST['workscout_register_nonce'], 'workscout-register-nonce')) {

        if ( !isset($_POST['confirm_email']) || $_POST['confirm_email'] !== '' ) {
            home_url( '/' );
            exit;
        }
        $user_login     = $_POST["workscout_user_login"];  
        $user_email     = $_POST["workscout_user_email"];
        $user_role      = $_POST["workscout_user_role"];
        $user_pass      = $_POST["workscout_user_pass"];
        $pass_confirm   = $_POST["workscout_user_pass_confirm"];
 
        if(username_exists($user_login)) {
            // Username already registered
            workscout_form_errors()->add('username_unavailable', __('Username already taken','workscout'));
        }
        if(!validate_username($user_login)) {
            // invalid username
            workscout_form_errors()->add('username_invalid', __('Invalid username','workscout'));
        }
        if($user_login == '') {
            // empty username
            workscout_form_errors()->add('username_empty', __('Please enter a username','workscout'));
        }
        if(!is_email($user_email)) {
            //invalid email
            workscout_form_errors()->add('email_invalid', __('Invalid email','workscout'));
        }
        if(email_exists($user_email)) {
            //Email address already registered
            workscout_form_errors()->add('email_used', __('Email already registered','workscout'));
        }
        if($user_pass == '') {
            // passwords do not match
            workscout_form_errors()->add('password_empty', __('Please enter a password','workscout'));
        }
        if($user_pass != $pass_confirm) {
            // passwords do not match
            workscout_form_errors()->add('password_mismatch', __('Passwords do not match','workscout'));
        }
        if(empty($user_role)) {
            $user_role = 'candidate';
        }
 
        $errors = workscout_form_errors()->get_error_messages();
        
        // only create the user in if there are no errors
        if(empty($errors)) {
 
            $new_user_id = wp_insert_user(array(
                    'user_login'        => $user_login,
                    'user_pass'         => $user_pass,
                    'user_email'        => $user_email,
                    'user_registered'   => date('Y-m-d H:i:s'),
                    'role'              => $user_role,
                )
            );
            if($new_user_id) {
                // send an email to the admin alerting them of the registration
                workscout_wp_new_user_notification($new_user_id,$user_pass);
 
                // log the new user in
                $creds = array();
                $creds['user_login'] = $user_login;
                $creds['user_password'] = $user_pass;
                $creds['remember'] = true;

                $user = wp_signon( $creds, false );
                // send the newly created user to the home page after logging them in
                if ( is_wp_error($user) ){
                    echo $user->get_error_message();
                } else {
                    wp_safe_redirect(  add_query_arg( 'success', 1,  home_url( '/' ) )  );
                }
                
                exit;
            }
 
        }
 
    }
}
add_action('init', 'workscout_add_new_member');

// used for tracking error messages
function workscout_form_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

function workscout_show_error_messages() {
    if($codes = workscout_form_errors()->get_error_codes()) {
        echo '<div class="notification closeable error">';
            // Loop error codes and display errors
           foreach($codes as $code){
                $message = workscout_form_errors()->get_error_message($code);
                echo '<span class="error">' . $message . '</span><br/>';
            }
        echo '</div>';
    }   
}

 function workscout_wp_new_user_notification($user_id, $plaintext_pass) {

    global $wpdb;
    $user = get_userdata( $user_id );

    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $message  = sprintf(__('New user registration on your site %s:','workscout'), $blogname) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s','workscout'), $user->user_login) . "\r\n\r\n";
    $message .= sprintf(__('E-mail: %s','workscout'), $user->user_email) . "\r\n";

    @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration','workscout'), $blogname), $message);

  
    $message = sprintf(__('Username: %s','workscout'), $user->user_login) . "\r\n\r\n";
    $message = sprintf(__('Password: %s','workscout'), $plaintext_pass) . "\r\n\r\n";

    $message .= __('To log into the admin area please us the following address','workscout') . wp_login_url() . "\r\n\r\n";

    $message .= wp_login_url() . "\r\n\r\n";
        $message .= sprintf( __('If you have any problems, please contact us at %s.','workscout'), get_option('admin_email') ) . "\r\n\r\n";
    $message .= __('Thank you!','workscout') . "\r\n\r\n";

    wp_mail($user->user_email, sprintf(__('[%s] Your username and password info','workscout'), $blogname), $message);
    }

//change password

function workscout_change_password_form() {
    global $post;   
 
    if (is_singular()) :
        $current_url = get_permalink($post->ID);
    else :
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $current_url = $pageURL;
    endif;      
    $redirect = $current_url;
 
    ob_start();
 
        // show any error messages after form submission
        workscout_show_error_messages(); ?>
 
        <?php if(isset($_GET['password-reset']) && $_GET['password-reset'] == 'true') { ?>
            <div class="workscout_message success">
                <span><?php _e('Password changed successfully', 'workscout'); ?></span>
            </div>
        <?php } ?>
        <form id="workscout_password_form" method="POST" action="<?php echo $current_url; ?>">
            <fieldset>
                <p>
                    <label for="workscout_user_pass"><?php _e('New Password', 'workscout'); ?></label>
                    <input name="workscout_user_pass" id="workscout_user_pass" class="required" type="password"/>
                </p>
                <p>
                    <label for="workscout_user_pass_confirm"><?php _e('Password Confirm', 'workscout'); ?></label>
                    <input name="workscout_user_pass_confirm" id="workscout_user_pass_confirm" class="required" type="password"/>
                </p>
                <p>
                    <input type="hidden" name="workscout_action" value="reset-password"/>
                    <input type="hidden" name="workscout_redirect" value="<?php echo $redirect; ?>"/>
                    <input type="hidden" name="workscout_password_nonce" value="<?php echo wp_create_nonce('workscout-password-nonce'); ?>"/>
                    <input id="workscout_password_submit" type="submit" value="<?php _e('Change Password', 'workscout'); ?>"/>
                </p>
            </fieldset>
        </form>
    <?php
    return ob_get_clean();  
}
 
// password reset form
function workscout_reset_password_form() {
    if(is_user_logged_in()) {
        return workscout_change_password_form();
    }
}
add_shortcode('password_form', 'workscout_reset_password_form');
 
 
function workscout_reset_password() {
    // reset a users password
    if(isset($_POST['workscout_action']) && $_POST['workscout_action'] == 'reset-password') {
 
        global $user_ID;
 
        if(!is_user_logged_in())
            return;
 
        if(wp_verify_nonce($_POST['workscout_password_nonce'], 'workscout-password-nonce')) {
 
            if($_POST['workscout_user_pass'] == '' || $_POST['workscout_user_pass_confirm'] == '') {
                // password(s) field empty
                workscout_form_errors()->add('password_empty', __('Please enter a password, and confirm it', 'workscout'));
            }
            if($_POST['workscout_user_pass'] != $_POST['workscout_user_pass_confirm']) {
                // passwords do not match
                workscout_form_errors()->add('password_mismatch', __('Passwords do not match', 'workscout'));
            }
 
            // retrieve all error messages, if any
            $errors = workscout_form_errors()->get_error_messages();
 
            if(empty($errors)) {
                // change the password here
                $user_data = array(
                    'ID' => $user_ID,
                    'user_pass' => $_POST['workscout_user_pass']
                );
                wp_update_user($user_data);
                // send password change email here (if WP doesn't)
                wp_redirect(add_query_arg('password-reset', 'true', $_POST['workscout_redirect']));
                exit;
            }
        }
    }   
}
add_action('init', 'workscout_reset_password');



/* AJAX LOGIN */
function workscout_ajax_login_init(){

    wp_register_script('workscout-ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('workscout-ajax-login-script');

    wp_localize_script( 'workscout-ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...','workscout')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_workscoutajaxlogin', 'workscout_ajax_login' );
    add_action( 'wp_ajax_nopriv_workscoutajaxregister', 'workscout_ajax_register' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'workscout_ajax_login_init');
}

function workscout_ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','workscout'), 'type'=>"error notification "));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','workscout'), 'type'=>"success notification "));
    }

    die();
}

function workscout_ajax_register(){
    
    check_ajax_referer( 'ajax-register-nonce', 'security' );
        
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = sanitize_user($_POST['username']);
    $info['user_pass'] = sanitize_text_field($_POST['password']);
    $info['user_pass_confirm'] = sanitize_text_field($_POST['password_again']);
    $info['user_email'] = sanitize_email( $_POST['email']);
    $info['user_role'] = sanitize_email( $_POST['role']);
    $valid = true;
    if(username_exists( $info['user_login'])) {
        // Username already registered
         echo json_encode(array('loggedin'=>false, 'message'=>__('Username already taken','workscout'), 'type'=>"error notification " ));
         $valid = false;
        die();
    }
    if(!validate_username( $info['user_login'])) {
        // invalid username
        echo json_encode(array('loggedin'=>false, 'message'=>__('Invalid username','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }
    if( $info['user_login'] == '') {
        // empty username
        echo json_encode(array('loggedin'=>false, 'message'=>__('Please enter a username','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }
    if(!is_email($info['user_email'])) {
        //invalid email
        echo json_encode(array('loggedin'=>false, 'message'=>__('Invalid email','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }
    if(email_exists($info['user_email'])) {
        //Email address already registered
        echo json_encode(array('loggedin'=>false, 'message'=>__('Email already registered','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }
    if($info['user_pass'] == '') {
        // passwords do not match
        echo json_encode(array('loggedin'=>false, 'message'=>__('Please enter a password','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }
    if($info['user_pass'] != $info['user_pass_confirm']) {
        // passwords do not match
        echo json_encode(array('loggedin'=>false, 'message'=>__('Passwords do not match','workscout'), 'type'=>"error notification " ));
        $valid = false;
        die();
    }

    // Register the user
    if($valid) {
        $user_register = wp_insert_user( $info );
        if ( is_wp_error($user_register) ){ 
            $error  = $user_register->get_error_codes() ;
            
            if(in_array('empty_user_login', $error))
                echo json_encode(array('loggedin'=>false, 'message'=>__($user_register->get_error_message('empty_user_login')), 'type'=>"error notification " ));
            elseif(in_array('existing_user_login',$error))
                echo json_encode(array('loggedin'=>false, 'message'=>__('This username is already registered.','workscout'), 'type'=>"error notification " ));
            elseif(in_array('existing_user_email',$error))
                echo json_encode(array('loggedin'=>false, 'message'=> __('This email address is already registered.','workscout'), 'type'=>"error notification " ));

        } else {

            $creds = array();
            $creds['user_login'] = $info['user_login'];
            $creds['user_password'] = $info['user_pass'];
            $creds['remember'] = true;

            $user_signon = wp_signon( $creds, false );
             if ( is_wp_error($user_signon) ){
                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','workscout'), 'type'=>"error notification " ));
            } else {
                wp_set_current_user($user_signon->ID); 
                echo json_encode(array('loggedin'=>true, 'message'=>__('Registration successful, redirecting...','workscout'), 'type'=>"success notification " ));
            } 
        }
    }

    die();
}
?>
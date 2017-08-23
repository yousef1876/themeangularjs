<?php
/**
 * Template Name: Page Template Login
 *
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage workscout
 * @since workscout 1.0
 */
$action = !empty( $_GET['action'] ) && ($_GET['action'] == 'register' || $_GET['action'] == 'forgot' || $_GET['action'] == 'resetpass') ? $_GET['action'] : 'login';

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div id="titlebar" class="single">
		<div class="container">

			<div class="sixteen columns">
				<h1><?php the_title(); ?></h1>
	        	<?php if(function_exists('bcn_display')) { ?>
		        <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<ul>
			        	<?php bcn_display_list(); ?>
			        </ul>
				</nav>
			<?php } ?>
			</div>
		</div>
	</div>

	<?php

		$layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);
		if(empty($layout)) { $layout = 'full-width'; }
		$class = ($layout !="full-width") ? "eleven columns" : "sixteen columns" ;

	?>

	<div class="container <?php echo esc_attr($layout); ?>">
		<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		<?php global $current_user; get_currentuserinfo(); 

			if ( is_user_logged_in() ) {?>
				
				<div id="login-register-password" class="columns six my-account woo-login-form">
					<?php if ( !empty($_GET['success']) ): ?>
								<div class="notification closeable success">
									<span class="icon-thumbs-up"></span>
									<?php _e('Profile updated successfully!','workscout') ?>
								</div>
					<?php endif; ?>

					<?php if ( !empty($error) ): ?>
						<div class="notification closeable error">
							<span class="icon-thumbs-up"></span>
							<?php echo $error; ?>
						</div>
					<?php endif; ?>
					<div class="sidebox">

				        <h3><?php esc_html_e('Welcome','workscout') ?>, <?php echo esc_html($user_identity); ?></h3>
				        
				        <div class="usericon">
				            <?php global $userdata; get_currentuserinfo(); echo get_avatar($userdata->ID, 100); ?>
				        </div>

				        <div class="userinfo">
				            <p><?php esc_html_e('You&rsquo;re logged in as','workscout'); ?> <strong><?php echo esc_html($user_identity); ?></strong></p>
				            <p>
				                <a class="button gray" href="<?php echo wp_logout_url('index.php');  ?>"><?php esc_html_e('Log out','workscout') ?></a>
				                <a class="button gray" href="?change_password=1"><?php esc_html_e('Change password','workscout') ?></a>

				                <?php if (current_user_can('manage_options')) {
				                    echo '<a class="button gray" href="' . esc_url(admin_url()) . '">' . esc_html__('Admin','workscout') . '</a>'; } else {
				                        echo '<a class="button gray" href="' . esc_url(admin_url()) . 'profile.php">' . esc_html__('Profile','workscout') . '</a>'; } ?>
				            </p>
				        </div>

				    </div>
					<?php if(isset($_GET['password-reset']) && $_GET['password-reset'] == 'true') { ?>
			           <div class="notification closeable success">
			                <p><?php _e('Password changed successfully', 'workscout'); ?></p>
			            </div>
			        <?php } ?>
					<?php if ( !empty($_GET['change_password']) ): ?>
						<h2><?php _e('Change password','workscout') ?></h2>
						<p><?php _e('You may change your password if you are so inclined.','workscout') ?></p>
						<?php echo do_shortcode('[password_form]'); ?> 
					<?php endif; ?>
					
				</div>
			
			<?php } else { ?>
				<div id="login-register-password" class="columns six my-account woo-login-form">
					<?php do_action('workscout-before-login'); ?>

						<ul class="tabs-nav-o" id="login-tabs">
							<li class="<?php if ($action == 'login') echo 'active'; ?>"><a href="#tab-login"><?php esc_html_e('Login','workscout'); ?></a></li>
							<?php if ( get_option( 'users_can_register' ) ) { ?>
								<li class="<?php if ($action == 'register') echo 'active'; ?>"><a href="#tab-register"><?php esc_html_e('Register','workscout'); ?></a></li> 
							<?php } ?>
						</ul>

						<div id="tab-login" class="tab-content"  style="<?php if ( $action != 'login' ) echo 'display:none' ?>">
							<?php echo do_shortcode('[login_form]');  ?> 
							<a href="<?php echo wp_lostpassword_url( home_url( '/' ) ); ?>" title="Lost Password">Lost Password?</a>
						</div>
						<?php if ( get_option( 'users_can_register' ) ) { ?>
							<div id="tab-register" class="tab-content" style="<?php if ( $action != 'register' ) echo 'display:none' ?>">
								<?php echo do_shortcode('[register_form]'); ?> 
							</div>
						<?php } ?>
					
						
				</div>			
			<?php } ?>
			<?php 
				the_content(); 
			?>
		</article>
	</div>

<?php endwhile; // End of the loop. ?>
<?php get_footer(); ?>
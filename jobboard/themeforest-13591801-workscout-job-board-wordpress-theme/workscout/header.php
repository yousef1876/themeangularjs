<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WorkScout
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<?php $layout = Kirki::get_option( 'workscout','pp_body_style','fullwidth' ); ?>
<body <?php body_class($layout); ?>>
<div id="wrapper">

<header id="main-header" class="<?php $style = Kirki::get_option( 'workscout','pp_header_style', 'default' ); echo $style; ?>">
<div class="container">
	<div class="sixteen columns">
	
		<!-- Logo -->
		<div id="logo">
			 <?php
                
                $logo = Kirki::get_option( 'workscout', 'pp_logo_upload', '' ); 
                if($logo) {
                    if(is_front_page()){ ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
                    <?php } else { ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
                    <?php }
                } else {
                    if(is_front_page()) { ?>
                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php } else { ?>
                    <h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
                    <?php }
                }
                ?>
                <?php if(get_theme_mod('workscout_tagline_switch','hide') == 'show') { ?><div id="blogdesc"><?php bloginfo( 'description' ); ?></div><?php } ?>
		</div>

		<!-- Menu -->
	
		<nav id="navigation" class="menu">

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'responsive','container' => false ) ); ?>

			<?php 
			$minicart_status = Kirki::get_option( 'workscout', 'pp_minicart_in_header', false );
			if(Kirki::get_option( 'workscout', 'pp_login_form_status', true ) ) { ?>
			<ul class="float-right">
			<?php if($minicart_status == 'on') {  get_template_part( 'inc/mini_cart'); } ?>
			<?php 
				if ( is_user_logged_in() ) { ?>
					<?php $loginpage = ot_get_option('pp_login_page');
					if( ! empty( $loginpage )) { $loginlink = get_permalink($loginpage); ?>
					<li><a href="<?php echo esc_url($loginlink); ?>"><i class="fa fa-sign-out"></i> <?php esc_html_e('User Page','workscout') ?></a></li>
					<?php } ?>
					<li><a href="<?php echo wp_logout_url( home_url() );  ?>"><i class="fa fa-sign-out"></i> <?php esc_html_e('Log Out','workscout') ?></a></li>
				</ul>
				<?php
				} else {
					if(ot_get_option('pp_login_form','on') == 'off') {
						$loginpage = ot_get_option('pp_login_page');
						if( ! empty( $loginpage )) {
						    $loginlink = get_permalink($loginpage);
						} else {
					    	$loginlink = wp_login_url( get_permalink() );
					    } ?>
							<li><a href="<?php echo esc_url($loginlink); ?>#tab-register"><i class="fa fa-user"></i> <?php esc_html_e('Sign Up','workscout') ?></a></li>
							<li><a href="<?php echo esc_url($loginlink); ?>"><i class="fa fa-lock"></i> <?php esc_html_e('Log In','workscout') ?></a></li>
						<?php 
						
					} else { ?>
							<li><a href="#singup-dialog" class="small-dialog popup-with-zoom-anim"><i class="fa fa-user"></i> <?php esc_html_e('Sign Up','workscout') ?></a></li>
							<li><a href="#login-dialog" class="small-dialog popup-with-zoom-anim"><i class="fa fa-lock"></i> <?php esc_html_e('Log In','workscout') ?></a></li>
					<?php } ?>


						</ul>
	
			<?php if(ot_get_option('pp_login_form','on') == 'on') { ?>
				<div id="singup-dialog" class="small-dialog zoom-anim-dialog mfp-hide apply-popup">
					<div class="small-dialog-headline">
						<h2><?php esc_html_e('Sign Up','workscout'); ?></h2>
					</div>
					<div class="small-dialog-content">
						<?php echo do_shortcode('[register_form]'); ?> 
					</div>
				</div>
				<div id="login-dialog" class="small-dialog zoom-anim-dialog mfp-hide apply-popup">
					<div class="small-dialog-headline">
						<h2><?php esc_html_e('Login','workscout'); ?></h2>
					</div>
					<div class="small-dialog-content">
						<?php echo do_shortcode('[login_form]');  ?> 
					</div>
				</div>
				<?php }
				} 
			}?>
		</nav>

		<!-- Navigation -->
		<div id="mobile-navigation">
			<a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i><?php esc_html_e('Menu','workscout'); ?></a>
		</div>

	</div>
</div>
</header>
<div class="clearfix"></div>
<?php if(isset($_GET['success']) && $_GET['success'] == 1 )  { ?>
	 <script type="text/javascript">
        jQuery(document).ready(function ($) {
    	
		    	$.magnificPopup.open({
				  items: {
				    src: '<div id="singup-dialog" class="small-dialog zoom-anim-dialog apply-popup">'+
		                	'<div class="small-dialog-headline"><h2><?php esc_html_e("Success!","workscout"); ?></h2></div>'+
		                	'<div class="small-dialog-content"><p class="margin-reset"><?php esc_html_e("You have successfully registered and logged in. Thank you!","workscout"); ?></p></div>'+
		        		'</div>', // can be a HTML string, jQuery object, or CSS selector
				    type: 'inline'
				  }
				});
	    	});
    </script>
<?php } ?>


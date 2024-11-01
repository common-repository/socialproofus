<?php
/*
/**
 SocialProofus
*/
if (!defined('ABSPATH')) {
    die;
}

/** constants */
class SPUPConstants
{
    public static function options_group()
    {
        return 'socailpu_options';
    }

    public static function option_debug_key() {
        return 'ps_debug';
    }

    public static function host() {
        return 'https://socialproofus.com';
    }

    public static function version() {
        return '1.0.8';
    }
}

define('SPUS_VERSION', 'v1.0.8');
define('SPUS_WEBSITE', 'https://socialproofus.com');


/* hooks */
add_action( 'admin_menu', 'socailpu_admin_menu' );
add_action( 'admin_init', 'socialproofus_init' ); //2.5.0
add_action('admin_notices', 'socailpu_admin_notice_html'); //3.1.0
add_action('wp_head', 'socailpu_inject_code'); //1.2.0
register_uninstall_hook(__FILE__, 'socailpu_uninstall_hook');
register_activation_hook(__FILE__, 'socailpu_activation_hook');
register_deactivation_hook(__FILE__, 'socailpu_deactivation_hook');


function socailpu_admin_menu() {
		add_menu_page(
			__( 'SocialProofUs', 'socialproofus.com' ),
			__( 'SocialProofUs', 'socialproofus.com' ),
			'manage_options',
			'socialproofus-page',
			'socailpu_contents',
			'dashicons-format-status',
			3
		);
	}
	
	/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function wporg_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wporg_dashboard_widget',                          // Widget slug.
		esc_html__( 'SocialProofUs Notifications', 'wporg' ), // Title.
		'wporg_dashboard_widget_render'                    // Display function.
	); 
}
add_action( 'wp_dashboard_setup', 'wporg_add_dashboard_widgets' );

/**
 * Create the function to output the content of our Dashboard Widget.
 */
function wporg_dashboard_widget_render() {
	// Display whatever you want to show.
	echo '<p>Welcome to SocialProofUs!<br><br>Login to your SocialProofUs <a href="https://SocialProofUs.com" target="_blank">account</a><br><br>SocialProofUs.com empowers your website with dynamic social proof notifications, offering over 27 options for free, while providing valuable insights into click impressions, CTR, and more, to optimize your online presence.<br><br> Need help? Contact us <a href="mailto:info@socialproofus.com">here</a></p>';

}


// END OF widget

function socailpu_inject_code()
{
	$pixelKey = get_option( 'socialproofus_field' );
    $version = SPUPConstants::version();?>

<!-- Pixel Code INJ for https://socialproofus.com/ --><script async src="https://socialproofus.com/pixel/<?php echo esc_html($pixelKey); ?>"></script><!-- END Pixel Code -->
    <?php
}

	function socailpu_contents() {
		?><BR/>
		<a href="https://socialproofus.com">
			<img class="top-logo" src="<?php echo plugin_dir_url(__FILE__).'assets/top-logo.png'; ?>">
		</a>
			<h1>
				<?php esc_html_e( 'Enhance Your Website for Free with SocialProofUs', 'socialproofus.com' ); ?> - <?php echo SPUS_VERSION; ?>
			</h1>
			<p>
				<?php echo __('Like this plugin?', 'socialproofus'); ?> <a href="https://wordpress.org/support/plugin/socialproofus/reviews/#new-post" target="_blank" title="<?php echo __('Review on WordPress.org', 'socialproofus'); ?>"><?php echo __('Please submit a review', 'socialproofus'); ?></a> <a href="https://wordpress.org/support/plugin/socialproofus/reviews/#new-post" target="_blank" title="<?php echo __('Review on WordPress.org', 'socialproofus'); ?>" style="text-decoration: none;">
					<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>
				</a>
			</p>
			<p style="font-size: 15px;">
				- <?php echo __('Want to support the developer?', 'socialproofus'); ?> <?php echo __('Feel free to', 'socialproofus'); ?> <a href="https://www.paypal.com/donate/?business=X2TAGWKQ8D7W6&no_recurring=0&item_name=Thank+you+so+much+for+your+donation.+Your+generosity+will+make+a+huge+difference.&currency_code=GBP" target="_blank"><?php echo __('Donate', 'socialproofus'); ?><span class="dashicons dashicons-external" style="font-size: 15px; margin-top: 5px; text-decoration: none;"></span></a>
			</p>
		   <form method="POST" action="options.php">
    <?php
    settings_fields( 'socialproofus-page' );
    do_settings_sections( 'socialproofus-page' );
    submit_button();
    ?>
    </form>
    <?php
}


function socialproofus_init() {

    add_settings_section(
        'socialproofus_page_setting_section',
        __( 'Settings', 'socialproofus.com' ),
        'socialproofus_section_callback_function',
        'socialproofus-page'
    );
	

		add_settings_field(
		   'socialproofus_field',
		   __( 'Enter your PIXEL code:', 'socialproofus.com' ),
		   'socialproofus_markup',
		   'socialproofus-page',
		   'socialproofus_page_setting_section'
		);

		register_setting( 'socialproofus-page', 'socialproofus_field' );
}

function socailpu_admin_notice_html()
{
	//$socialproofus_field = get_option( 'socialproofus_field' );
    if( ! empty( get_option( 'socialproofus_field' ) ) ) {
        return;
    }


    ?>

	<div class="notice notice-error is-dismissible">
        <p class="ps-error">SocialProofUs Requires Configuration <a href="admin.php?page=socialproofus-page">Click here</a></p>
    </div>
		
	<?php
}

function socialproofus_section_callback_function() {
	$arrspu = array( 'br' => array(), 'p' => array(), 'strong' => array() );
	$strspu='<p>Choose from 27+ Free Notifications & Track Your Success with SocialProofUs.com!</p>
    <p>To utilize the SocialProofUs WordPress plugin, it is essential to have an active account with us.</p> 
	<p>Having an account ensures seamless integration and access to all the features and benefits offered by our plugin.</p>
	<p>If you encounter any issues with the pixel code on your website, we recommend clearing your browser cache and then rechecking the pixel code implementation.</P>
	<p>Should you require further assistance, please dont hesitate to reach out to our support team at info@socialproofus.com</p>
	<p>Please enter the PIXEL code from your account on Socialproofus.com.</p>';
    $response = wp_remote_get( 'https://socialproofus.com/pixel/' );
    $http_code = wp_remote_retrieve_response_code( $response );
    //if ($http_code == "200") {
     //  echo 'Socialproofus.com status is: <font color="green">Online</font>';
    //} else {
	//   echo 'Socialproofus.com status is: <font color="red">Connection Interupted</font>';	
   // }
	echo wp_kses( $strspu, $arrspu );
	
}

function socialproofus_markup() {
	$pixelKey = get_option( 'socialproofus_field' );
	$registersocial = 'https://socialproofus.com/register';
	$signinsocial = 'https://socialproofus.com/login';
    ?>
	<input type="text" placeholder="required" id="socialproofus_field" name="socialproofus_field" size="32" value="<?php echo esc_html($pixelKey); ?>" /><br><br>
	<button onclick="location.href='<?php echo esc_url($registersocial);?>'" type="button">
         Register for a free account</button> | 
	<button onclick="location.href='<?php echo esc_url($signinsocial);?>'" type="button">
         Sign in</button><br><br>
    <?php

}
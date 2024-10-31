<?php
/**
 * Settings Page template.
 *
 * @package Sell_Services
 */

?>
<div class="wrap about-wrap">
	<?php

	require_once( plugin_dir_path( __FILE__ ) . 'parts/welcome.php' );
	do_action( 'sell_services_settings_after_welcome' );

	require_once( plugin_dir_path( __FILE__ ) . 'parts/tabs.php' );
	do_action( 'sell_services_settings_after_tabs' );

	require_once( plugin_dir_path( __FILE__ ) . 'parts/about.php' );
	do_action( 'sell_services_settings_after_about' );

	require_once( plugin_dir_path( __FILE__ ) . 'parts/settings.php' );
	do_action( 'sell_services_settings_after_settings' );
	?>
</div>

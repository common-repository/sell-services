<?php
/**
 * Welcome section.
 *
 * @package Sell_Services
 */

?>
<h1><?php echo esc_html( get_admin_page_title() ); ?> </h1>
<div class="about-text">
	<?php $plugin_data = get_plugin_data( SELL_SERVICES_PLUGIN_FILE ); ?>
	<?php
	echo sprintf(
		/* translators: %1$s - Plugin name. */
		esc_html__( 'Congratulations! You have successfully installed %1$s version %2$s. It is ready to serve you with its full potential. There are just a few more steps necessary to finalize the setup of the plugin and to learn more about its features.', 'sell-services' ),
		esc_html( $plugin_data['Name'] ),
		esc_html( $plugin_data['Version'] )
	); ?>
</div>
<a target="_blank" href="<?php echo esc_url( 'https://www.blackbell.com/en' ); ?>" class="wp-badge"><?php echo esc_html( 'BlackBell' ); ?></a>




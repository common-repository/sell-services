<?php
/**
 * Settings section.
 *
 * @package Sell_Services
 */

?>
<div id="settings" class="ish-tab-pane <?php echo esc_attr( ( $this->is_tab_active( 'settings' ) ) ? 'ish-is-active' : '' ); ?>">
	<form action="options.php" method="post">
		<?php
		// Output security fields for the registered setting.
		settings_fields( 'sell_services_settings' );

		// Output setting sections and their fields for this settings page.
		do_settings_sections( 'sell_services_settings' );

		// output save settings button.
		submit_button( 'Save Settings' );
		?>
	</form>
</div>

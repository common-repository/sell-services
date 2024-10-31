<?php
/**
 * Tabs navigation.
 *
 * @package Sell_Services
 */

?>
<h2 class="nav-tab-wrapper">
	<a href="#about" class="nav-tab <?php echo esc_attr( ( $this->is_tab_active( 'about' ) ) ? 'nav-tab-active' : '' ); ?>"><?php esc_html_e( 'About', 'sell-services' ); ?></a>
	<a href="#settings" class="nav-tab <?php echo esc_attr( ( $this->is_tab_active( 'settings' ) ) ? 'nav-tab-active' : '' ); ?>"><?php esc_html_e( 'Settings', 'sell-services' ); ?></a>
</h2>

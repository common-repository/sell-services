<?php
/**
 * About section.
 *
 * @package Sell_Services
 */

?>
<div id="about" class="ish-tab-pane <?php echo esc_attr( ( $this->is_tab_active( 'about' ) ) ? 'ish-is-active' : '' ); ?>">
	<div class="feature-section two-col">
		<div class="col">
			<p><?php esc_html_e( 'Blackbell simplifies selling, marketing and operations.', 'sell-services' ); ?></p>
			<p><?php esc_html_e( 'It is your happy place: manage every area of your business, making it agile, effortless to run, and more profitable.', 'sell-services' ); ?></p>
			<p><?php esc_html_e( 'Blackbell offers your customers a faster booking experience while giving you a workspace where orders are organized and accessible.', 'sell-services' ); ?></p>
			<p><?php esc_html_e( 'A single platform for taking orders, managing calendars, accepting payments, organizing service delivery, and most of all promoting your services. Use Blackbell promotional tools to create coupons, email previous customers, create influencers promo codes and sell via marketplaces.', 'sell-services' ); ?></p>
			<p><?php esc_html_e( 'No credit card required - 14-day free trial.', 'sell-services' ); ?></p>
			<p>
				<a href="<?php echo esc_url( 'https://www.blackbell.com/wordpress' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Learn More', 'sell-services' ); ?></a>
				<a href="<?php echo esc_url( 'https://www.blackbell.com/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Create an Account', 'sell-services' ); ?></a>
			</p>
		</div>

		<div class="col">
			<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../images/plugin-demo.gif' ); ?>" alt="">
		</div>
	</div>
</div>

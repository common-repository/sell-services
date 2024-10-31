<?php
/**
 * Plugin Name:  Sell Services
 * Plugin URI:   https://www.blackbell.com/wordpress
 * Description:  Blackbell simplifies selling, marketing and operations. It is your happy place to manage every area of your business.
 * Version:      1.0.2
 * Author:       blackbell.com
 * Author URI:   https://www.blackbell.com/en
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:  /languages
 *
 * @package Sell_Services
 */

// Exit if plugin accessed outside of WordPress.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Sell_Services' ) ) {
	/**
	 * Class Sell_Services
	 */
	class Sell_Services {

		/**
		 * Prefix for options
		 *
		 * @var string Prefix for options
		 */
		private $prefix = 'sell_services_';

		/**
		 * The name of the currently active tab
		 *
		 * @var string The name of the currently active tab
		 */
		private $active_tab;

		/**
		 * The slug of this plugin
		 *
		 * @var string The slug of this plugin
		 */
		private $plugin_slug;

		/**
		 * Sell_Services constructor.
		 */
		function __construct() {

			// Plugin version.
			if ( ! defined( 'SELL_SERVICES_VERSION' ) ) {
				define( 'SELL_SERVICES_VERSION', '1.0.1' );
			}

			// Plugin Root File.
			if ( ! defined( 'SELL_SERVICES_PLUGIN_FILE' ) ) {
				define( 'SELL_SERVICES_PLUGIN_FILE', __FILE__ );
			}

			$this->plugin_slug = dirname( plugin_basename( __FILE__ ) );
			$this->active_tab = 'about';

			// Initialize Plugin functionality.
			add_action( 'init', array( $this, 'init' ) );

			// Initialize Plugin functionality for Admin area.
			add_action( 'admin_init', array( $this, 'admin_init' ) );

			// Register all settings for the settings page.
			add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );

			// Remove plugin data when plugin uninstalled (data remain after deactivation).
			register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );

			// Detect plugin activation.
			register_activation_hook( __FILE__, array( $this, 'plugin_activate' ) );

			// Redirect plugin to plugin page after activation.
			add_action( 'admin_init', array( $this, 'plugin_redirect' ) );

			// Enable admin notices.
			add_action( 'admin_notices', array( $this, 'missing_settings_notice' ) );

		}

		/**
		 * Sell_Services initialization function.
		 */
		public function init() {

			// Plugin Settings page in WordPress administration.
			add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

			// Register all scripts to be added to WordPress front-end.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fe_scripts' ) );
		}


		/**
		 * Initialize Plugin functionality for Admin area.
		 */
		public function admin_init() {

			// Add additional links to the plugin row in the plugins list in administration area.
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );

			// Register all admin CSS styles and JS scripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		}

		/**
		 * Filter to add additional links for the plugin.
		 *
		 * @param array $actions list of actions.
		 * @return array
		 */
		public function plugin_action_links( $actions ) {

			$home = array(
				'blackbell-home' => sprintf(
					'<a href="%s">%s</a>',
					admin_url( 'options-general.php?page=sell-services#about' ),
					__( 'About', 'sell-services' )
				),
			);

			if ( current_user_can( 'manage_options' ) ) {
				return array_merge(
					$home,
					array(
						'settings' => sprintf(
							'<a href="%s">%s</a>',
							admin_url( 'options-general.php?page=sell-services#settings' ),
							__( 'Settings', 'sell-services' )
						),
					),
					$actions
				);
			}

			return array_merge( $home, $actions );
		}

		/**
		 * Removes plugin data when plugin uninstalled.
		 */
		public static function uninstall() {

			// Create a new instance of the class.
			$snippet = new Sell_Services();

			// Remove plugin data when plugin uninstalled.
			delete_option( $snippet->prefix . 'settings' );

			// Destroy the new instance of snippet class.
			unset( $snippet );

		}

		/**
		 * Redirection after plugin is activated.
		 */
		public function plugin_redirect() {
			if ( get_option( 'sell_services_do_activation_redirect', false ) ) {
				delete_option( 'sell_services_do_activation_redirect' );
				exit( esc_html( wp_redirect( 'options-general.php?page=sell-services#about' ) ) );
			}
		}

		/**
		 * Sell_Services after plugin gets activated.
		 */
		public function plugin_activate() {
			add_option( 'sell_services_do_activation_redirect', true );
		}

		/**
		 * Add a new sub-menu page under "Settings" menu in WordPress admin.
		 */
		public function add_settings_page() {

			add_options_page( esc_html__( 'Sell Services', 'sell-services' ), esc_html__( 'Sell Services Plugin', 'sell-services' ), 'manage_options', 'sell-services', array(
				$this,
				'settings_page_detail',
			) );
		}

		/**
		 * Registers all sections and fields for the Plugin's settings page.
		 */
		public function register_plugin_settings() {
			$settings_page = $this->prefix . 'settings';

			// register a new setting for "sell_services_settings" page.
			register_setting( $settings_page, $settings_page );

			add_settings_section( 'default', '', array( $this, 'output_settings_section_callback' ), $settings_page );

			// register a new field for the settings page.
			add_settings_field(
				$this->prefix . 'app_url',
				esc_html__( 'Blackbell App URL', 'sell-services' ),
				array(
					$this,
					'setting_field_callback',
				), $settings_page, 'default', array(
					'label_for'     => $this->prefix . 'app_url',
					'id'            => 'app_url',
					'label_text'    => esc_html__( 'All links to this URL will be opened in a pop-up modal.', 'sell-services' ),
					'placeholder'   => esc_html__( 'E.g. https://myappid.blackbell.com', 'sell-services' ),
				)
			);
		}

		/**
		 * Callback function generating section HTML.
		 *
		 * @param array $args all argument set in "add_settings_section" function.
		 */
		public function output_settings_section_callback( $args ) {
			// No section intro text needed so far.
		}

		/**
		 * Callback function generating setting field HTML.
		 *
		 * @param array $args all argument set in "add_settings_field" function.
		 */
		public function setting_field_callback( $args ) {

			$settings_slug = $this->prefix . 'settings';

			if ( isset( $args ) && isset( $args['id'] ) ) {
				// get the value of the setting we've registered with register_setting().
				$options = get_option( $settings_slug );

				// output the field.
				?>
				<input
					type="text"
					name="<?php echo esc_attr( $settings_slug . '[' . $args['id'] . ']' ); ?>"
					id="<?php echo esc_attr( $args['label_for'] ); ?>"
					placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
					value="<?php echo ( isset( $options['app_url'] ) ) ? esc_attr( $options['app_url'] ) : ''; ?>"
					class="regular-text"/>
				<?php

				if ( isset( $args['label_text'] ) ) { ?>
					<p class="description"
					   id="<?php echo esc_attr( $args['id'] ); ?>-description"><?php echo esc_html( $args['label_text'] ); ?></p>
				<?php }
			}
		}

		/**
		 * Loads all Plugin front-end scripts.
		 */
		public function enqueue_fe_scripts() {

			// Get the saved options plugin Options.
			$options = get_option( $this->prefix . 'settings' );

			// Only enqueue the scripts if "app_url" exists.
			if ( isset( $options['app_url'] ) && ! empty( $options['app_url'] ) ) {

				// Enqueue the core JS Snippet functionality.
				wp_enqueue_script( 'sell-services-core', 'https://d3nbcimkkva5qh.cloudfront.net/js-integration/widget.latest.js', array( 'jquery' ), SELL_SERVICES_VERSION, true );

				// Initialize the JS Snippet.
				wp_enqueue_script( 'sell-services-main', plugin_dir_url( __FILE__ ) . 'public/js/main.js', array(
					'jquery',
					'sell-services-core',
				), SELL_SERVICES_VERSION, true );

				// Prepare data for script localization.
				$data = array(
					'snippet_url' => ( isset( $options['app_url'] ) ) ? str_replace( 'http://', 'https://', untrailingslashit( esc_url( $options['app_url'] ) ) ) : '',
				);

				// Send the data to the main script.
				wp_localize_script( 'sell-services-main', 'bb_data', $data );
			}

		}


		/**
		 * Loads all Plugin front-end scripts.
		 *
		 * @param string $hook The current hook name.
		 */
		public function enqueue_admin_scripts( $hook ) {

			if ( "settings_page_{$this->plugin_slug}" !== $hook ) {
				return;
			}

			wp_enqueue_style( "{$this->plugin_slug}-dashboard-style", plugin_dir_url( __FILE__ ) . 'assets/css/admin.css' );
			wp_enqueue_script( "{$this->plugin_slug}-dashboard-script", plugin_dir_url( __FILE__ ) . '/admin/js/admin.js', array( 'jquery' ), '', true );
		}

		/**
		 * Outputs the HTML for the Plugin's settings page.
		 */
		public function settings_page_detail() {

			// check user capabilities.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$notices = get_settings_errors( 'general' );

			if ( ! empty( $notices ) && ( 'settings_updated' === $notices[0]['code'] ) ) {
				$this->active_tab = 'settings';
			}

			require_once( plugin_dir_path( __FILE__ ) . 'admin/settings-page.php' );

		}

		/**
		 * Checks whether the current tab is active.
		 *
		 * @param string $tab The name of the tab.
		 * @return bool
		 */
		public function is_tab_active( $tab ) {
			return ( $this->active_tab === $tab );
		}

		/**
		 * Outputs notices.
		 */
		function missing_settings_notice() {

			// Get the saved options plugin Options.
			$options = get_option( $this->prefix . 'settings' );
			$plugin_data = get_plugin_data( __FILE__ );

			// Only continue if "app_url" missing or empty.
			if ( ! isset( $options['app_url'] ) || empty( $options['app_url'] ) ) {
				?>
				<div class="notice notice-error qusq-lite-notice is-dismissible">
					<p>
						<?php printf(
							// Translators: %1$s - Plugin name.
							esc_html__( '%1$s plugin is not set up correctly. Continue to %2$s to finalize setup.', 'sell-services' ),
							esc_html( $plugin_data['Name'] ),
							'<a href="' . esc_url( admin_url( 'options-general.php?page=sell-services#settings' ) ) . '"><strong>' . esc_html__( 'Plugin Settings Page' , 'sell-services' ) . '</strong></a>'
						);
						?>
					</p>
				</div>
				<?php
			}
		}
	}
} // End if().

$sell_services = new Sell_Services();

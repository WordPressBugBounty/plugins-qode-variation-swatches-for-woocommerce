<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

class Qode_Variation_Swatches_For_WooCommerce_Admin_Notice {
	private static $instance;

	public $plugin_slug = 'qode-variation-swatches-for-woocommerce';

	public $plugin_name = 'QODE Variation Swatches for WooCommerce';


	public function __construct() {

		// Include scripts for plugin notice.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );

		// Add plugin deactivation notice.
		add_action( 'current_screen', array( $this, 'add_deactivation_notice' ) );

		// Function that handles plugin notice.
		add_action( 'wp_ajax_qode_variation_swatches_for_woocommerce_deactivation', array( $this, 'handle_deactivation' ) );
	}

	/**
	 * Instance of module class
	 *
	 * @return Qode_Variation_Swatches_For_WooCommerce_Admin_Notice
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_script() {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_register_script( 'qode-variation-swatches-for-woocommerce-notice', QODE_VARIATION_SWATCHES_FOR_WOOCOMMERCE_ADMIN_URL_PATH . '/inc/admin-notice/assets/js/admin-notice.min.js', array( 'jquery' ), false, false );
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_register_style( 'qode-variation-swatches-for-woocommerce-notice', QODE_VARIATION_SWATCHES_FOR_WOOCOMMERCE_ADMIN_URL_PATH . '/inc/admin-notice/assets/css/admin-notice.min.css' );
	}

	public function add_deactivation_notice() {
		if ( ! $this->is_plugins_screen() ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'load_deactivation_module' ) );
	}

	public function load_deactivation_module() {
		add_action( 'admin_footer', array( $this, 'print_deactivation_form' ) );

		wp_enqueue_script( 'qode-variation-swatches-for-woocommerce-notice' );
		wp_enqueue_style( 'qode-variation-swatches-for-woocommerce-notice' );
	}

	public function print_deactivation_form() {
		$params['plugin_slug'] = str_replace( '-', '_', $this->plugin_slug );
		$params['plugin_name'] = $this->plugin_name;

		qode_variation_swatches_for_woocommerce_framework_template_part( QODE_VARIATION_SWATCHES_FOR_WOOCOMMERCE_ADMIN_PATH . '/inc', 'admin-notice', 'templates/admin-deactivation-form', '', $params );
	}

	private function is_plugins_screen() {
		return in_array( get_current_screen()->id, array( 'plugins', 'plugins-network' ), true );
	}

	public function handle_deactivation() {
		check_ajax_referer( 'qode-variation-swatches-for-woocommerce-deactivation-nonce', 'nonce' );

		$data = array(
			'plugin'                 => $this->plugin_slug,
			'site_lang'              => get_bloginfo( 'language' ),
			'reason'                 => isset( $_POST['reason'] ) ? sanitize_text_field( wp_unslash( $_POST['reason'] ) ) : '',
			'reason_additional_info' => isset( $_POST['additionalInfo'] ) ? sanitize_text_field( wp_unslash( $_POST['additionalInfo'] ) ) : '',
			'date'                   => date_i18n( 'Y-m-d H:i:s' ),
		);

		$request_handler_url = 'https://api.qodeinteractive.com/plugin-deactivation-feedback.php';

		$response = wp_remote_post(
			$request_handler_url,
			array(
				'body' => $data,
			)
		);

		$response_body = json_decode( wp_remote_retrieve_body( $response ) );

		if ( $response_body->success ) {
			qode_variation_swatches_for_woocommerce_get_ajax_status( 'success', esc_html__( 'Thank you for the feedback!', 'qode-variation-swatches-for-woocommerce' ) );
		} else {
			qode_variation_swatches_for_woocommerce_get_ajax_status( 'fail', esc_html__( 'Something went wrong with sending feedback.', 'qode-variation-swatches-for-woocommerce' ) );
		}
	}
}

Qode_Variation_Swatches_For_WooCommerce_Admin_Notice::get_instance();

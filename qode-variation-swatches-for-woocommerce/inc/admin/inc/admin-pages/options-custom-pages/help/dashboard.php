<?php
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

if ( ! function_exists( 'qode_variation_swatches_for_woocommerce_add_help_custom_options_page' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function qode_variation_swatches_for_woocommerce_add_help_custom_options_page() {
		$custom_page = Qode_Variation_Swatches_For_WooCommerce_Admin_Options_Custom_Page_Handler::get_instance();

		$custom_page->add_page(
			array(
				'slug'     => 'help',
				'title'    => esc_html__( 'Help', 'qode-variation-swatches-for-woocommerce' ),
				'position' => 2,
				'script'   => false,
				'icon'     => '<svg xmlns="http://www.w3.org/2000/svg" width="15.498" height="15.498" viewBox="0 0 15.498 15.498"><g transform="translate(-194.999 -620.751)"><path stroke="none" d="M141.649-804.5a1.591,1.591,0,0,1-1.169-.479,1.591,1.591,0,0,1-.479-1.169v-12.2a1.591,1.591,0,0,1,.479-1.169,1.591,1.591,0,0,1,1.169-.479h12.2a1.591,1.591,0,0,1,1.169.479,1.591,1.591,0,0,1,.479,1.169v12.2a1.591,1.591,0,0,1-.479,1.169,1.591,1.591,0,0,1-1.169.479Zm0-1.367h12.2a.268.268,0,0,0,.193-.088.268.268,0,0,0,.088-.193v-12.2a.268.268,0,0,0-.088-.193.268.268,0,0,0-.193-.088h-12.2a.268.268,0,0,0-.193.088.268.268,0,0,0-.088.193v12.2a.268.268,0,0,0,.088.193A.268.268,0,0,0,141.649-805.868Zm-.281-12.763v0Z" transform="translate(54.998 1440.75)" /><path stroke="none" d="M1.989-2.717,1.937-4.771H2.4a7.429,7.429,0,0,0,1.008-.065,2.569,2.569,0,0,0,.839-.254,1.431,1.431,0,0,0,.578-.546,1.789,1.789,0,0,0,.214-.929,1.691,1.691,0,0,0-.208-.865,1.362,1.362,0,0,0-.591-.546,1.964,1.964,0,0,0-.878-.188,2,2,0,0,0-.891.188,1.387,1.387,0,0,0-.591.533,1.568,1.568,0,0,0-.208.826H.442A2.6,2.6,0,0,1,.806-7.995a2.458,2.458,0,0,1,1.027-.93,3.387,3.387,0,0,1,1.534-.332,3.413,3.413,0,0,1,1.521.325,2.5,2.5,0,0,1,1.04.923,2.651,2.651,0,0,1,.377,1.443,2.659,2.659,0,0,1-.4,1.527,2.351,2.351,0,0,1-1.112.871,4.423,4.423,0,0,1-1.632.279L3.12-2.717ZM2.561.065a.836.836,0,0,1-.617-.241A.789.789,0,0,1,1.7-.754a.8.8,0,0,1,.24-.592.836.836,0,0,1,.617-.24.814.814,0,0,1,.611.24.816.816,0,0,1,.234.592.8.8,0,0,1-.234.579A.814.814,0,0,1,2.561.065Z" transform="translate(199 633)" /></g></svg>',
			)
		);
	}

	add_action( 'init', 'qode_variation_swatches_for_woocommerce_add_help_custom_options_page', 9 );
}

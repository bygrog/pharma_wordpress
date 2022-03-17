<?php

if ( ! function_exists( 'neoocular_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function neoocular_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'neoocular_filter_mobile_header_template', neoocular_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'neoocular_action_page_header_template', 'neoocular_load_page_mobile_header' );
}

if ( ! function_exists( 'neoocular_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function neoocular_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'neoocular_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'neoocular' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'neoocular_action_after_include_modules', 'neoocular_register_mobile_navigation_menus' );
}

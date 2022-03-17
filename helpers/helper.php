<?php

if ( ! function_exists( 'neoocular_is_installed' ) ) {
	/**
	 * Function that checks if forward plugin installed
	 *
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function neoocular_is_installed( $plugin ) {

		switch ( $plugin ) {
			case 'framework':
				return class_exists( 'QodeFramework' );
			case 'core':
				return class_exists( 'NeoOcularCore' );
			case 'woocommerce':
				return class_exists( 'WooCommerce' );
			case 'gutenberg-page':
				$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : array();

				return method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor();
			case 'gutenberg-editor':
				return class_exists( 'WP_Block_Type' );
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'neoocular_include_theme_is_installed' ) ) {
	/**
	 * Function that set case is installed element for framework functionality
	 *
	 * @param bool $installed
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function neoocular_include_theme_is_installed( $installed, $plugin ) {

		if ( 'theme' === $plugin ) {
			return class_exists( 'Neoocular_Handler' );
		}

		return $installed;
	}

	add_filter( 'qode_framework_filter_is_plugin_installed', 'neoocular_include_theme_is_installed', 10, 2 );
}

if ( ! function_exists( 'neoocular_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 */
	function neoocular_template_part( $module, $template, $slug = '', $params = array() ) {
		echo neoocular_get_template_part( $module, $template, $slug, $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'neoocular_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function neoocular_get_template_part( $module, $template, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = NEOOCULAR_INC_ROOT_DIR . '/' . $module;

		$temp = $template_path . '/' . $template;
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params ); // @codingStandardsIgnoreLine
		}

		$template = '';

		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";

				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		if ( $template ) {
			ob_start();
			include( $template ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'neoocular_get_page_id' ) ) {
	/**
	 * Function that returns current page id
	 * Additional conditional is to check if current page is any wp archive page (archive, category, tag, date etc.) and returns -1
	 *
	 * @return int
	 */
	function neoocular_get_page_id() {
		$page_id = get_queried_object_id();

		if ( neoocular_is_wp_template() ) {
			$page_id = - 1;
		}

		return apply_filters( 'neoocular_filter_page_id', $page_id );
	}
}

if ( ! function_exists( 'neoocular_is_wp_template' ) ) {
	/**
	 * Function that checks if current page default wp page
	 *
	 * @return bool
	 */
	function neoocular_is_wp_template() {
		return is_archive() || is_search() || is_404() || ( is_front_page() && is_home() );
	}
}

if ( ! function_exists( 'neoocular_get_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 *
	 * @param string $status - success or error
	 * @param string $message - ajax message value
	 * @param string|array $data - returned value
	 * @param string $redirect - url address
	 */
	function neoocular_get_ajax_status( $status, $message, $data = null, $redirect = '' ) {
		$response = array(
			'status'   => esc_attr( $status ),
			'message'  => esc_html( $message ),
			'data'     => $data,
			'redirect' => ! empty( $redirect ) ? esc_url( $redirect ) : '',
		);

		$output = json_encode( $response );

		exit( $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'neoocular_get_button_element' ) ) {
	/**
	 * Function that returns button with provided params
	 *
	 * @param array $params - array of parameters
	 *
	 * @return string - string representing button html
	 */
	function neoocular_get_button_element( $params ) {
		if ( class_exists( 'NeoOcularCore_Button_Shortcode' ) ) {
			return NeoOcularCore_Button_Shortcode::call_shortcode( $params );
		} else {
			$link   = isset( $params['link'] ) ? $params['link'] : '#';
			$target = isset( $params['target'] ) ? $params['target'] : '_self';
			$text   = isset( $params['text'] ) ? $params['text'] : '';

			return '<a itemprop="url" class="qodef-theme-button" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '">' . esc_html( $text ) . '</a>';
		}
	}
}

if ( ! function_exists( 'neoocular_render_button_element' ) ) {
	/**
	 * Function that render button with provided params
	 *
	 * @param array $params - array of parameters
	 */
	function neoocular_render_button_element( $params ) {
		echo neoocular_get_button_element( $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'neoocular_class_attribute' ) ) {
	/**
	 * Function that render class attribute
	 *
	 * @param string|array $class
	 */
	function neoocular_class_attribute( $class ) {
		echo neoocular_get_class_attribute( $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'neoocular_get_class_attribute' ) ) {
	/**
	 * Function that return class attribute
	 *
	 * @param string|array $class
	 *
	 * @return string|mixed
	 */
	function neoocular_get_class_attribute( $class ) {
		return neoocular_is_installed( 'framework' ) ? qode_framework_get_class_attribute( $class ) : '';
	}
}

if ( ! function_exists( 'neoocular_get_post_value_through_levels' ) ) {
	/**
	 * Function that returns meta value if exists
	 *
	 * @param string $name name of option
	 * @param int $post_id id of
	 *
	 * @return string value of option
	 */
	function neoocular_get_post_value_through_levels( $name, $post_id = null ) {
		return neoocular_is_installed( 'framework' ) && neoocular_is_installed( 'core' ) ? neoocular_core_get_post_value_through_levels( $name, $post_id ) : '';
	}
}

if ( ! function_exists( 'neoocular_get_space_value' ) ) {
	/**
	 * Function that returns spacing value based on selected option
	 *
	 * @param string $text_value - textual value of spacing
	 *
	 * @return int
	 */
	function neoocular_get_space_value( $text_value ) {
		return neoocular_is_installed( 'core' ) ? neoocular_core_get_space_value( $text_value ) : 0;
	}
}

if ( ! function_exists( 'neoocular_wp_kses_html' ) ) {
	/**
	 * Function that does escaping of specific html.
	 * It uses wp_kses function with predefined attributes array.
	 *
	 * @param string $type - type of html element
	 * @param string $content - string to escape
	 *
	 * @return string escaped output
	 * @see wp_kses()
	 *
	 */
	function neoocular_wp_kses_html( $type, $content ) {
		return neoocular_is_installed( 'framework' ) ? qode_framework_wp_kses_html( $type, $content ) : $content;
	}
}

if ( ! function_exists( 'neoocular_render_svg_icon' ) ) {
	/**
	 * Function that print svg html icon
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 */
	function neoocular_render_svg_icon( $name, $class_name = '' ) {
		echo neoocular_get_svg_icon( $name, $class_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'neoocular_get_svg_icon' ) ) {
	/**
	 * Returns svg html
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 *
	 * @return string - string containing svg html
	 */
	function neoocular_get_svg_icon( $name, $class_name = '' ) {
		$html  = '';
		$class = isset( $class_name ) && ! empty( $class_name ) ? 'class="' . esc_attr( $class_name ) . '"' : '';

		switch ( $name ) {
			case 'menu':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><line x1="12" y1="21" x2="52" y2="21"/><line x1="12" y1="33" x2="52" y2="33"/><line x1="12" y1="45" x2="52" y2="45"/></svg>';
				break;
			case 'search':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15.22px" height="15.1px" viewBox="0 0 15.22 15.1" enable-background="new 0 0 15.22 15.1" xml:space="preserve"><circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="9.053" cy="6.167" r="5.667"/><line fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-miterlimit="10" x1="0.6" y1="14.5" x2="4.746" y2="10.354"/></svg>';
				break;
			case 'star':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 20.756,11.768L 15.856,1.84L 10.956,11.768L0,13.36L 7.928,21.088L 6.056,32L 15.856,26.848L 25.656,32L 23.784,21.088L 31.712,13.36 z"></path></g></svg>';
				break;
			case 'menu-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z"></path></g></svg>';
				break;
			case 'slider-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 50.9" xml:space="preserve"><polyline points="25.6,0.4 0.7,25.5 25.6,50.6 "/></svg>';
				break;
			case 'slider-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 50.9" xml:space="preserve"><polyline points="0.4,50.6 25.3,25.5 0.4,0.4 "/></svg>';
				break;
			case 'pagination-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906" enable-background="new 0 0 6.344 10.906" xml:space="preserve"><g><path d="M5.883,10.41c-0.329,0.315-0.652,0.315-0.967,0L0.447,5.942C0.304,5.827,0.232,5.67,0.232,5.469 s0.072-0.358,0.215-0.473l4.468-4.468c0.316-0.315,0.638-0.315,0.967,0c0.331,0.315,0.323,0.63-0.021,0.945L1.908,5.469 l3.953,3.996C6.205,9.78,6.212,10.095,5.883,10.41z"/></g></svg>';
				break;
			case 'pagination-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"	width="6.344px" height="10.906px" viewBox="0 0 6.344 10.906" enable-background="new 0 0 6.344 10.906" xml:space="preserve"><g><path d="M0.496,9.465l3.953-3.996L0.496,1.473c-0.344-0.315-0.352-0.63-0.021-0.945 c0.329-0.315,0.651-0.315,0.967,0L5.91,4.996c0.143,0.115,0.215,0.272,0.215,0.473c0,0.201-0.072,0.358-0.215,0.473L1.441,10.41 c-0.315,0.315-0.638,0.315-0.967,0C0.145,10.095,0.152,9.78,0.496,9.465z"/></g></svg>';
				break;
			case 'close':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 10.050,23.95c 0.39,0.39, 1.024,0.39, 1.414,0L 17,18.414l 5.536,5.536c 0.39,0.39, 1.024,0.39, 1.414,0 c 0.39-0.39, 0.39-1.024,0-1.414L 18.414,17l 5.536-5.536c 0.39-0.39, 0.39-1.024,0-1.414c-0.39-0.39-1.024-0.39-1.414,0 L 17,15.586L 11.464,10.050c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 15.586,17l-5.536,5.536 C 9.66,22.926, 9.66,23.56, 10.050,23.95z"></path></g></svg>';
				break;
			case 'spinner':
				$html = '<svg ' . $class . ' viewBox="0 0 100 100"><g><circle cx="50" cy="50" r="50"></circle><circle cx="5" cy="50" r="4"></circle><circle cx="95" cy="50" r="4"></circle></g></svg>';
				break;
			case 'link':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="37.574px" height="37.351px" viewBox="0 0 37.574 37.351" enable-background="new 0 0 37.574 37.351" xml:space="preserve"><g><path d="M1.857,11.247c-0.891-0.89-1.336-2.062-1.336-3.516c0-2.015,0.679-3.679,2.039-4.992 c1.078-1.125,2.496-1.793,4.254-2.004s3.199,0.2,4.324,1.23l7.172,7.242c1.078,1.032,1.617,2.32,1.617,3.867 c0,0.517-0.07,1.032-0.211,1.547L9.099,4.004C8.442,3.537,7.658,3.419,6.743,3.653c-0.914,0.235-1.629,0.61-2.145,1.125 C3.801,5.576,3.404,6.56,3.404,7.731c0,0.61,0.164,1.102,0.492,1.477l10.688,10.617c-2.109,0.61-3.938,0.141-5.484-1.406 L1.857,11.247z M13.036,11.036l13.219,13.218c0.327,0.281,0.492,0.633,0.492,1.055s-0.152,0.786-0.457,1.09 c-0.306,0.306-0.668,0.457-1.09,0.457s-0.773-0.163-1.055-0.492L10.927,13.145c-0.328-0.281-0.492-0.633-0.492-1.055 s0.151-0.784,0.457-1.09c0.305-0.304,0.668-0.457,1.09-0.457S12.755,10.709,13.036,11.036z M35.325,26.152 c0.89,0.892,1.336,2.063,1.336,3.516c0,2.017-0.68,3.681-2.039,4.992c-1.125,1.125-2.556,1.793-4.289,2.004 c-1.734,0.211-3.164-0.2-4.289-1.23l-7.172-7.242c-1.079-1.03-1.617-2.32-1.617-3.867c0-0.515,0.07-1.03,0.211-1.546l10.617,10.617 c0.656,0.47,1.441,0.587,2.355,0.352c0.914-0.233,1.628-0.608,2.145-1.125c0.797-0.796,1.195-1.78,1.195-2.953 c0-0.608-0.165-1.101-0.492-1.477L22.599,17.575c2.109-0.608,3.938-0.141,5.484,1.406L35.325,26.152z"/></g></svg>';
				break;
			case 'quote':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36.83px" height="32.44px" viewBox="0 0 36.83 32.44" enable-background="new 0 0 36.83 32.44" xml:space="preserve"><g><path d="M2.841,30.096c1.171-1.452,2.132-2.999,2.883-4.641c-3.375-2.858-5.063-6.28-5.063-10.265 c0-4.031,1.746-7.476,5.238-10.336c3.491-2.858,7.699-4.289,12.621-4.289s9.129,1.431,12.621,4.289 c3.491,2.86,5.238,6.305,5.238,10.336c0,4.032-1.747,7.488-5.238,10.371c-3.492,2.883-7.699,4.324-12.621,4.324 c-1.594,0-3.516-0.187-5.766-0.563c-2.953,1.735-5.977,2.602-9.07,2.602c-0.469,0-0.809-0.211-1.02-0.633 S2.512,30.471,2.841,30.096z M7.763,24.189c0.468,0.329,0.585,0.751,0.352,1.266c-0.517,1.406-1.195,2.767-2.039,4.078 c1.874-0.327,3.82-1.101,5.836-2.32c0.281-0.141,0.563-0.187,0.844-0.141c1.922,0.376,3.843,0.563,5.766,0.563 c4.313,0,7.991-1.218,11.039-3.656c3.047-2.436,4.57-5.366,4.57-8.789c0-3.421-1.523-6.339-4.57-8.754 c-3.048-2.414-6.727-3.621-11.039-3.621c-4.313,0-7.992,1.208-11.039,3.621c-3.048,2.415-4.57,5.333-4.57,8.754 C2.911,18.705,4.529,21.706,7.763,24.189z"/></g></svg>';
				break;
			case 'reply':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12.542px" height="7.938px" viewBox="0 0 12.542 7.938" enable-background="new 0 0 12.542 7.938" xml:space="preserve"><g><path d="M12.202,3.776L9.39,6.589C9.175,6.823,8.955,6.828,8.73,6.603C8.506,6.38,8.511,6.16,8.745,5.944 l1.992-2.021H3.911c-0.879,0-1.567,0.333-2.065,0.996C1.348,5.583,1.099,6.344,1.099,7.204c0,0.137-0.044,0.249-0.132,0.337 s-0.2,0.132-0.337,0.132S0.381,7.629,0.293,7.541s-0.132-0.2-0.132-0.337c0-1.172,0.303-2.168,0.908-2.988s1.553-1.23,2.842-1.23 h6.826L8.745,0.964C8.511,0.749,8.506,0.529,8.73,0.304C8.955,0.081,9.175,0.085,9.39,0.319l2.813,2.813 C12.437,3.347,12.437,3.561,12.202,3.776z"/></g></svg>';
				break;
			case 'edit':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12.797px" height="12.672px" viewBox="0 0 12.797 12.672" enable-background="new 0 0 12.797 12.672" xml:space="preserve"><g><path d="M1.956,0.616L2.94,1.6L1.581,2.959L0.597,1.975C0.409,1.787,0.315,1.561,0.315,1.295 c0-0.266,0.094-0.492,0.281-0.68s0.414-0.281,0.68-0.281S1.769,0.428,1.956,0.616z M6.245,7.6L2.378,3.756l1.359-1.359l3.844,3.867 l0.68,2.016L6.245,7.6z M12.093,2.807c0.148,0.148,0.223,0.324,0.223,0.527v8.25c0,0.203-0.074,0.379-0.223,0.527 s-0.324,0.223-0.527,0.223h-8.25c-0.203,0-0.379-0.074-0.527-0.223s-0.223-0.324-0.223-0.527v-5.32l0.75,0.75v4.57h8.25v-8.25 h-4.57l-0.75-0.75h5.32C11.769,2.584,11.944,2.658,12.093,2.807z"/></g></svg>';
				break;
			case 'heart':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="18px" height="15.453px" viewBox="0 0 18 15.453" enable-background="new 0 0 18 15.453" xml:space="preserve"><g><path d="M18,5.272v0.035v0.035c0,0.023-0.006,0.059-0.018,0.105c-0.012,0.047-0.018,0.083-0.018,0.105	c-0.023,0.961-0.217,1.881-0.58,2.76s-0.797,1.641-1.301,2.285c-0.504,0.645-1.102,1.248-1.793,1.811s-1.318,1.02-1.881,1.371 s-1.148,0.673-1.757,0.967c-0.61,0.293-1.02,0.475-1.23,0.545S9.047,15.42,8.93,15.468c-0.118-0.047-0.281-0.111-0.492-0.193 c-0.211-0.083-0.615-0.264-1.213-0.545s-1.172-0.598-1.723-0.949c-0.551-0.352-1.166-0.814-1.846-1.389 c-0.68-0.574-1.271-1.178-1.775-1.811C1.376,9.948,0.949,9.192,0.598,8.313s-0.54-1.798-0.563-2.76 c0-0.023-0.006-0.058-0.018-0.105C0.005,5.401,0,5.366,0,5.343V5.308c0-0.023,0-0.047,0-0.07c0.023-1.383,0.533-2.596,1.529-3.639 c0.996-1.042,2.174-1.564,3.533-1.564c1.594,0,2.906,0.691,3.938,2.074c1.031-1.383,2.343-2.074,3.937-2.074 c1.359,0,2.537,0.522,3.533,1.564C17.466,2.642,17.976,3.854,18,5.237V5.272z M16.875,5.343c0-0.023,0-0.047,0-0.07 c-0.023-1.125-0.422-2.092-1.195-2.9s-1.688-1.213-2.742-1.213c-1.219,0-2.227,0.54-3.023,1.617C9.68,3.081,9.375,3.233,9,3.233 c-0.375,0-0.68-0.152-0.914-0.457C7.289,1.699,6.281,1.159,5.063,1.159c-1.055,0-1.969,0.404-2.742,1.213s-1.172,1.775-1.195,2.9 c0,0.023,0,0.047,0,0.07C1.148,5.39,1.16,5.437,1.16,5.483C1.183,6.515,1.429,7.5,1.898,8.437c0.469,0.938,1.002,1.711,1.6,2.32 c0.598,0.61,1.295,1.184,2.092,1.723c0.796,0.54,1.441,0.926,1.934,1.16c0.492,0.234,0.961,0.445,1.406,0.633 c0.445-0.188,0.919-0.398,1.424-0.633c0.504-0.234,1.16-0.621,1.968-1.16c0.809-0.539,1.518-1.113,2.127-1.723 c0.609-0.609,1.154-1.383,1.635-2.32c0.48-0.937,0.732-1.91,0.756-2.918C16.839,5.448,16.851,5.39,16.875,5.343z"/></g></svg>';
				break;
		}

		return apply_filters( 'neoocular_filter_svg_icon', $html );
	}
}

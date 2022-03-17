<?php

if ( ! function_exists( 'neoocular_register_required_plugins' ) ) {
	/**
	 * Function that registers theme required and optional plugins. Hooks to tgmpa_register hook
	 */
	function neoocular_register_required_plugins() {
		$plugins = array(
			array(
				'name'               => esc_html__( 'Qode Framework', 'neoocular' ),
				'slug'               => 'qode-framework',
				'source'             => NEOOCULAR_INC_ROOT_DIR . '/plugins/qode-framework.zip',
				'version'            => '1.1.8',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'               => esc_html__( 'NeoOcular Core', 'neoocular' ),
				'slug'               => 'neoocular-core',
				'source'             => NEOOCULAR_INC_ROOT_DIR . '/plugins/neoocular-core.zip',
				'version'            => '1.0',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'               => esc_html__( 'Revolution Slider', 'neoocular' ),
				'slug'               => 'revslider',
				'source'             => NEOOCULAR_INC_ROOT_DIR . '/plugins/revslider.zip',
				'version'            => '6.5.9',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'               => esc_html__( 'NeoOcular Membership', 'neoocular' ),
				'slug'               => 'neoocular-membership',
				'source'             => NEOOCULAR_INC_ROOT_DIR . '/plugins/neoocular-membership.zip',
				'version'            => '1.0',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'               => esc_html__( 'Booked', 'neoocular' ),
				'slug'               => 'booked',
				'source'             => NEOOCULAR_INC_ROOT_DIR . '/plugins/booked.zip',
				'version'            => '2.3.5',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'     => esc_html__( 'Elementor Page Builder', 'neoocular' ),
				'slug'     => 'elementor',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'Qi Addons for Elementor', 'neoocular' ),
				'slug'     => 'qi-addons-for-elementor',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'WooCommerce Plugin', 'neoocular' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Contact Form 7', 'neoocular' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Custom Twitter Feeds', 'neoocular' ),
				'slug'     => 'custom-twitter-feeds',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Instagram Feed', 'neoocular' ),
				'slug'     => 'instagram-feed',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Envato Market', 'neoocular' ),
				'slug'     => 'envato-market',
				'source'   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'YITH Whishlist', 'neoocular' ),
				'slug'     => 'yith-woocommerce-wishlist',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'YITH Quickview', 'neoocular' ),
				'slug'     => 'yith-woocommerce-quick-view',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'YITH Color and Label Variations', 'neoocular' ),
				'slug'     => 'yith-color-and-label-variations-for-woocommerce',
				'required' => false,
			),
		);

		$config = array(
			'domain'       => 'neoocular',
			'default_path' => '',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'menu'         => 'install-required-plugins',
			'has_notices'  => true,
			'is_automatic' => false,
			'message'      => '',
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'neoocular' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'neoocular' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'neoocular' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'neoocular' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'neoocular' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'neoocular' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this website for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'neoocular' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'neoocular' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'neoocular' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this website for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'neoocular' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'neoocular' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this website for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'neoocular' ),
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'neoocular' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'neoocular' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'neoocular' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'neoocular' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'neoocular' ),
				'nag_type'                        => 'updated',
			),
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'neoocular_register_required_plugins' );
}

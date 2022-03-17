<?php if ( class_exists( 'NeoOcularCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-e-info-item-right qodef-e-info-social-share">
		<?php
		$params                      = array();
		$params['layout']            = 'dropdown';
		$params['dropdown_behavior'] = 'left';
		$params['title']             = ' ';
		$params['icon_font']         = 'elegant-icons';

		echo NeoOcularCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>

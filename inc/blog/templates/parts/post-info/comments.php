<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<?php comments_number( '0 ' . esc_html__( 'Comments', 'neoocular' ), '1 ' . esc_html__( 'Comment', 'neoocular' ), '% ' . esc_html__( 'Comments', 'neoocular' ) ); ?>
	</a><div class="qodef-info-separator-end"></div>
<?php } ?>

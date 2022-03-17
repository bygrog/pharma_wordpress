<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post format part
		neoocular_template_part( 'blog', 'templates/parts/post-format/link' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-info qodef-info--top">
				<?php
				// Include post date info
				neoocular_template_part( 'blog', 'templates/parts/post-info/date' );

				// Include post category info
				neoocular_template_part( 'blog', 'templates/parts/post-info/categories' );
				?>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'neoocular_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
					// Include post tags info
					neoocular_template_part( 'blog', 'templates/parts/post-info/tags' );
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					if ( ! neoocular_is_installed( 'core' ) ) {
						// Include post comments info
						neoocular_template_part( 'blog', 'templates/parts/post-info/comments' );
					}

					neoocular_template_part( 'blog', 'templates/parts/post-info/social-share' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>

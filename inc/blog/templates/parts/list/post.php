<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		neoocular_template_part( 'blog', 'templates/parts/post-info/media' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					neoocular_template_part( 'blog', 'templates/parts/post-info/date' );

					// Include post category info
					neoocular_template_part( 'blog', 'templates/parts/post-info/categories' );

					if ( ! neoocular_is_installed( 'core' ) ) {
						// Include post category info
						neoocular_template_part( 'blog', 'templates/parts/post-info/tags' );
					}
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				neoocular_template_part( 'blog', 'templates/parts/post-info/title', '', array( 'title_tag' => 'h2' ) );

				// Include post excerpt
				neoocular_template_part( 'blog', 'templates/parts/post-info/excerpt' );

				// Hook to include additional content after blog single content
				do_action( 'neoocular_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left">
					<?php
					// Include post read more
					neoocular_template_part( 'blog', 'templates/parts/post-info/read-more' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>

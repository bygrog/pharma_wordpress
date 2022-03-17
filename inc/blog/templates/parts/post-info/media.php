<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			neoocular_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			neoocular_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			neoocular_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			neoocular_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>

<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package lucerne
 */

get_header(); ?>

	<div id="error-page" class="container-fluid">
		<div class="center-content">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'lucerne' ); ?></h1>
		</div>
	</div>

<?php
get_footer();

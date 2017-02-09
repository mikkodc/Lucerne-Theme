<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lucerne
 */

get_header(); ?>

	<?php
		while ( have_posts() ) { the_post(); ?>

			<div id="ajax-container">
				<?php get_template_part('template-parts/content-linked') ?>
			</div>

		<?php }

//get_sidebar();
get_footer(); ?>
<script>
  var templateDir = "<?php bloginfo('template_directory') ?>";
</script>

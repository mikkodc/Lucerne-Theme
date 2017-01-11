<?php
//Intro Article
function intro_article() {

	get_template_part( 'template-parts/content-linked' );

	die();

}

add_action( 'wp_ajax_intro_article', 'intro_article' );
add_action( 'wp_ajax_nopriv_intro_article', 'intro_article' ); ?>

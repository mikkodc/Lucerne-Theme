<?php

class introArticle {

	public function __construct() {
		add_action(
      'wp_ajax_intro_article',
      array($this, 'intro_article')
    );
    add_action(
      'wp_ajax_nopriv_intro_article',
      array($this, 'intro_article')
    );
		add_action(
			'wp_ajax_counter_increase',
			'runViewCounter'
		);
	}

	public function intro_article() {

		$post_id = $_GET['article'];
		$queried_post = get_post($post_id);
	  $current_article = $queried_post->ID;

		// get_template_part( 'template-parts/content-linked' );

		echo '<iframe src="'. the_field("article_link", $current_article) .'" class="linked-frame"></iframe>';

		die();

	}
}
?>

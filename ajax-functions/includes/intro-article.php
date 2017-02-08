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

		get_template_part( 'template-parts/content-linked' );

		die();

	}
}
?>

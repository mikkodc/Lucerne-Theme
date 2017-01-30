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
	}

	public function intro_article() {

		// if (!isset($_COOKIE['visits'])) {
	  //   $_COOKIE['visits'] = 0;
	  //   $visits = $_COOKIE['visits'] + 1;
	  //   setcookie('visits',$visits,time()+3600*24*365);
	  // }

		get_template_part( 'template-parts/content-linked' );

		die();

	}
}
?>

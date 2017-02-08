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
      'wp_ajax_add_view',
      array($this, 'add_view')
    );
    add_action(
      'wp_ajax_nopriv_add_view',
      array($this, 'add_view')
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

	public function add_view() {

		$post_id = $_GET['article'];
		setPostViews($post_id); ?>
		<h2><?php echo $post_id = $_GET['article']; ?></h2>
		<script>
			alert('test');
		</script>

		<?php die();

	}
}
?>

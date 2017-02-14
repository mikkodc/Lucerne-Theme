<?php

class readingList {

	public function __construct() {

    //Insert Post to Reading List
    add_action(
      'wp_ajax_insert_reading_list',
      array($this, 'insert_reading_list')
    );
    add_action(
      'wp_ajax_nopriv_insert_reading_list',
      array($this, 'insert_reading_list')
    );

    //Remove Post to Reading List
    add_action(
      'wp_ajax_remove_reading_list',
      array($this, 'remove_reading_list')
    );
    add_action(
      'wp_ajax_nopriv_remove_reading_list',
      array($this, 'remove_reading_list')
    );

    //Initialize Reading List
    add_action(
      'wp_ajax_init_reading_list',
      array($this, 'init_reading_list')
    );
    add_action(
      'wp_ajax_nopriv_init_reading_list',
      array($this, 'init_reading_list')
    );
	}

  // Insert Post to Reading List
  public function insert_reading_list(){

  	$insert_post = $_GET['article'];
  	$user_inserted = wp_get_current_user();

  	global $wpdb;
  	$table = $wpdb->prefix . "reading_list";

  	$user = $user->ID;
  	$wpdb->insert(
  			$table,
  			array(
  					'user_id' => $user_inserted->ID,
  					'post_id' => $insert_post,
  					'created_at' => date('Y-m-d H:i:s')
  			)
  	);

  	get_template_part( 'template-parts/content-readlist' );

  	die();
  }

  // Remove Post to Reading List
  public function remove_reading_list(){

  	$insert_post = $_GET['article'];

  	global $wpdb;
  	$table = $wpdb->prefix . "reading_list";

  	$wpdb->insert(
  			$table,
  			array(
  					'user_id' => $user_inserted->ID,
  					'post_id' => $insert_post,
  					'created_at' => date('Y-m-d H:i:s')
  			)
  	);
  	$wpdb->delete( $table,
  		array(
  			'post_id' => $insert_post
  		)
  	);

  	die();
  }

  //Init Reading List
  public function init_reading_list(){

  	global $wpdb;

  	$user_inserted = wp_get_current_user();
  	$current_user_id = $user_inserted->ID;

  	$currentReadList = $wpdb->get_col(
  		"
  		SELECT post_id
  		FROM wp_reading_list
  		WHERE user_id = '".$current_user_id. "'
  		"
  	);

  	if(!$currentReadList) { ?>
  		<!-- <p class="is-empty no-content text-center">Your reading list is empty.</p> -->
  	<?php } else {
  		foreach ($currentReadList as $readList) {
  			$articleQuery = get_post($readList); ?>
				<div class="item-container clearfix" data-id="<?php echo $articleQuery->ID ?>">
			    <div class="col-xs-10 article-item">
			      <a class="ajax-link" data-id="<?php echo $articleQuery->ID ?>">
			        <img src="<?php echo get_the_post_thumbnail_url($articleQuery->ID, 'article-thumb'); ?>" alt="" class="img-responsive">
			        <div class="meta-overlay">
			          <div class="meta-date">
			            <?php
			              $author_name = get_field('author_name', $articleQuery->ID);
			              if($author_name) {
			                echo $author_name;
			              } else {
			                echo mysql2date('j F, Y', $articleQuery->post_date);
			              } ?>
			          </div>
			        </div>
			      </a>
			      <h4 class="article-title"><a class="ajax-link" data-id="<?php echo $articleQuery->ID ?>"><?php echo $articleQuery->post_title; ?></a></h4>
			    </div>
			    <div class="col-xs-2 remove-item">
			      <a href="#" data-id="<?php echo $articleQuery->ID ?>" class="remove-to-list"><span class="glyphicon glyphicon-remove"></span></a>
			    </div>
			  </div>
  		<?php }
  	}
  	die();
  }
}
?>

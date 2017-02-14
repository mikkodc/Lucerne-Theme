<?php
/**
 * Dashboard Reporting
 *
 */

//Cookies Setup

// Setup Visit Count
function getPostVisits($postID){
  $count_key = 'post_visits_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count=='1' || $count == ''){
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '1');
      return $count." Visit";
  }
  return $count.' Visits';
}

function setPostVisits($postID) {
  $count_key = 'post_visits_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count==''){
    $count = 1;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '1');
  }else{
    $count++;
    update_post_meta($postID, $count_key, $count);

  	$user_inserted = wp_get_current_user();

  	global $wpdb;
  	$table = $wpdb->prefix . "reporting";

  	$user = $user_inserted->ID;
    if(checkExist($user, $postID) >= 1) {
      $wpdb->update(
  			$table,
        array(
      		'visited_at' => current_time( 'mysql' ),
      	),
      	array( 'post_id' => $postID ),
        array('%s')
    	);
    } else {
      $wpdb->insert(
  			$table,
  			array(
					'user_id' => $user,
					'post_id' => $postID,
					'visited_at' => current_time( 'mysql' )
  			)
    	);
    }
  }
}

// Setup View Count
function getPostViews($postID){
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count=='1' || $count == ''){
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '1');
      return $count." View";
  }
  return $count.' Views';
}

function setPostViews($postID) {
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count==''){
    $count = 1;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '1');
  } else{
    $count++;
    update_post_meta($postID, $count_key, $count);

  	$user_inserted = wp_get_current_user();

    global $wpdb;
  	$table = $wpdb->prefix . "reporting";

  	$user = $user_inserted->ID;

    if(checkExist($user, $postID) >= 1) {
      $wpdb->update(
  			$table,
        array(
      		'viewed_at' => current_time( 'mysql' ),
      	),
      	array( 'post_id' => $postID ),
        array('%s')
    	);
    } else {
      $wpdb->insert(
  			$table,
  			array(
					'user_id' => $user,
					'post_id' => $postID,
					'viewed_at' => current_time( 'mysql' )
  			)
    	);
    }
  }
}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//Check if user and post_id exists
function checkExist($user, $postID) {
  global $wpdb;

  $checkexist = $wpdb->get_var(
    "
    SELECT count(id)
    FROM wp_reporting
    WHERE user_id = '".$user. "'
      AND post_id = '".$postID."'
    "
  );

  return $checkexist;
}

//Function for Displaying Reports
function displayReports($q) { ?>
  <ul>
  <?php
  foreach ($q as $key => $value) {
    echo "<li>" .$key;
    $view_total = 0;

    foreach ($value as $key => $post_view) {
      $view_total+= $post_view;
    }
    echo "<span> (" .$view_total. " Visits)</span></li>";
  }
  ?>
  </ul>
<?php }

//Function for processing Reports Array
function articlesReport($post_meta_key, $label) {
  // args
  $args = array(
  	'numberposts'	=> -1,
  );

  // query
  $the_query = new WP_Query( $args );
  if( $the_query->have_posts() ){
    $page_view_count = array();
    while( $the_query->have_posts() ) {
      $the_query->the_post();

      $pagevisit = get_post_meta(get_the_ID(), $post_meta_key, true);

      if ($pagevisit != 0) {
        $page_view_count[] = array(
          'post_title' => get_the_title(),
          'post_view' => $pagevisit,
          'post_permalink' => get_the_permalink()
        );
      }
      ?>
    <?php }
  }
  wp_reset_query();

  array_multisort($page_view_count);
  $sorted = val_sort($page_view_count, 'post_view'); ?>

  <!-- <pre><?php //print_r($sorted); ?></pre> -->
  <?php //var_dump($sorted); ?>
  <ul>
    <?php foreach ($sorted as $postname) { ?>
      <li>
        <a href="<?= $postname['post_permalink']; ?>">
          <?php echo $postname['post_title']; ?>
        </a><span><?php echo "(". $postname['post_view'] . " " . $label ."s)"; ?></span>
      </li>
    <?php } ?>
  </ul>
<?php }


// Setup Sorting (High to Low)
function val_sort($array,$key) {

	//Loop through and get the values of our specified key
	foreach($array as $k=>$v) {
		$b[] = strtolower($v[$key]);
	}

	// print_r($b);

	krsort($b);

	// echo '<br />';
	// print_r($b);

	foreach($b as $k=>$v) {
		$c[] = $array[$k];
	}

  $newArray = array_slice($c, 0, 5, true);

	return $newArray;
}

include( get_template_directory() . '/inc/widget-reporting/last-login.php');
include( get_template_directory() . '/inc/widget-reporting/last-viewed-widget.php');
include( get_template_directory() . '/inc/widget-reporting/last-visited-widget.php');
include( get_template_directory() . '/inc/widget-reporting/popular-category.php');
include( get_template_directory() . '/inc/widget-reporting/popular-author.php');

?>

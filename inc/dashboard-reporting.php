<?php
/**
 * Dashboard Reporting
 *
 */

//Cookies Setup
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
  }else{
      $count++;
      update_post_meta($postID, $count_key, $count);
  }
}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

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

	return $c;
}

include( get_template_directory() . '/inc/widget-reporting/last-login.php');
include( get_template_directory() . '/inc/widget-reporting/last-viewed-widget.php');
include( get_template_directory() . '/inc/widget-reporting/last-visited-widget.php');
include( get_template_directory() . '/inc/widget-reporting/popular-category.php');
include( get_template_directory() . '/inc/widget-reporting/popular-author.php');

?>

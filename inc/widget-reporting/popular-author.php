<?php
add_action('wp_dashboard_setup', 'popular_author_widget');

function popular_author_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('author_data_widget', 'Popular Author', 'popular_author_container');
}

function popular_author_container() {

  // args
  $args = array(
  	'numberposts'	=> -1,
  );

  // query
  $the_query = new WP_Query( $args );
  if( $the_query->have_posts() ){
    $page_view_count = array();
    $q = array();
    $posts_name = array();

    while( $the_query->have_posts() ) {
      $the_query->the_post();

      $post_count_ID = get_the_ID();
      $count = get_post_meta($post_count_ID, 'post_visits_count', true);
      $staff_object = get_field('assign_staff_member', $post_count_ID);
      $staff_member = $staff_object->post_title;

      if($staff_member) {
        $b = $staff_member;
      } else {
        $b = get_the_author();
      }

      $q[$b][] = $count; // Create an array with the category names and post titles

    }
  }
  wp_reset_query();

  $added_views = array();
  foreach ($q as $key => $value) {

    $view_total = 0;

    foreach ($value as $post_view) {
      $view_total+= $post_view;
    }

    $added_views[] = array(
      'view_total' => $view_total,
      'auth_name' => $key
    );
  }

  array_multisort($added_views);
  $count = val_sort($added_views, 'view_total');

  echo "<ul>";
  foreach ($count as $category) {
      echo "<li>" .$category['auth_name']. " (" . $category['view_total'] . " Views)</li>";
  }
  echo "</ul>";



} ?>

<?php

add_action('wp_dashboard_setup', 'view_clients_widget');

function view_clients_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('clients_data_widget', 'View Report by Client', 'view_clients_container');
}

function view_clients_container() {

  $args = array(
   'role' => 'subscriber',
   'orderby' => 'user_nicename',
   'order' => 'ASC'
  );
  $subscribers = get_users($args);

  // var_dump($subscribers);
  echo '<a data-id="0">View All</a>';
  echo '<ul class="select-users">';
  foreach ($subscribers as $user) {
    echo '<li><a data-id="'. $user->ID .'">' . $user->display_name.' ['.$user->user_email . ']</a></li>';
  }
  echo '</ul>';

  // // args
  // $args = array(
  // 	'numberposts'	=> -1,
  // );
  //
  // // query
  // $the_query = new WP_Query( $args );
  // if( $the_query->have_posts() ){
  //   $page_view_count = array();
  //   $q = array();
  //   $posts_name = array();
  //
  //   while( $the_query->have_posts() ) {
  //     $the_query->the_post();
  //
  //     $post_count_ID = get_the_ID();
  //     $count = get_post_meta($post_count_ID, 'post_visits_count', true);
  //     $staff_object = get_field('assign_staff_member', $post_count_ID);
  //     $staff_member = $staff_object->post_title;
  //
  //     if($staff_member) {
  //       $b = $staff_member;
  //     } else {
  //       $b = get_the_author();
  //     }
  //
  //     $q[$b][] = $count; // Create an array with the category names and post titles
  //
  //   }
  // }
  // wp_reset_query();
  //
  // $added_views = array();
  // foreach ($q as $key => $value) {
  //
  //   $view_total = 0;
  //
  //   foreach ($value as $post_view) {
  //     $view_total+= $post_view;
  //   }
  //
  //   $added_views[] = array(
  //     'view_total' => $view_total,
  //     'auth_name' => $key
  //   );
  // }
  //
  // array_multisort($added_views);
  // $count = val_sort($added_views, 'view_total');
  //
  // echo "<ul>";
  // foreach ($count as $category) {
  //     echo "<li>" .$category['auth_name']. " (" . $category['view_total'] . " Views)</li>";
  // }
  // echo "</ul>";



} ?>

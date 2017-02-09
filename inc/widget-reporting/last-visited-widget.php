<?php
add_action('wp_dashboard_setup', 'last_visited_widget');

function last_visited_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('visited_data_widget', 'Last 5 Articles Visited', 'last_visited_container');
}

function last_visited_container() {

  articlesReport(post_visits_count, Visit);

  global $wpdb;

  $clientsViews = $wpdb->get_results(
    "
    SELECT *
    FROM wp_reporting
    WHERE visited_at != '0000-00-00 00:00:00'
    "
  );

  $arrangeUsers = array();
  foreach($clientsViews as $clients) {
    $user = $clients->user_id;

    $arrangeUsers[$clients->user_id][] = array (
      'visited_at' => $clients->visited_at,
      'post_id' => $clients->post_id
    );
  }


  // echo '<pre>';
  // print_r($clientsViews);
  // echo '</pre>';

  // echo '<pre>';
  // print_r($arrangeUsers);
  // echo '</pre>';

} ?>

<?php
add_action('wp_dashboard_setup', 'last_visited_widget');

function last_visited_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('visited_data_widget', 'Last 5 Articles Visited', 'last_visited_container');
}

function last_visited_container() {

  articlesReport(post_visits_count, Visit);

} ?>

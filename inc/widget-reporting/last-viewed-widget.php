<?php
add_action('wp_dashboard_setup', 'last_viewed_widget');

function last_viewed_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('viewed_data_widget', 'Last 5 Articles Viewed', 'last_viewed_container');
}

function last_viewed_container() {

  articlesReport(post_views_count, View);

} ?>

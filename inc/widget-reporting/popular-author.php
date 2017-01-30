<?php
add_action('wp_dashboard_setup', 'popular_author_widget');

function popular_author_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('author_data_widget', 'Popular Author', 'popular_author_container');
}

function popular_author_container() {

  wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC&number=5');
  
  }
 ?>

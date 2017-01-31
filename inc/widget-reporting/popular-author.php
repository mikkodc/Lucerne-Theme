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

      $count = get_post_meta(get_the_ID(), 'post_visits_count', true);
      $author = get_the_author();

      $q[$author][] = $count; // Create an array with the category names and post titles

    }

  }
  wp_reset_query();


  // array_multisort($page_view_count);
  // $sorted = val_sort($page_view_count, 'post_view');
  displayReports($q);
  ?>

  <!-- <pre><?php //print_r($q); ?></pre> -->

<?php } ?>

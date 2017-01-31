<?php
add_action('wp_dashboard_setup', 'popular_category_widget');

function popular_category_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('category_data_widget', 'Popular Categories', 'popular_category_container');
}

function popular_category_container() {

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


      $a = '<a href="'. get_permalink() .'">' . get_the_title() .'</a>';
      $count = get_post_meta(get_the_ID(), 'post_visits_count', true);

      $categories = get_the_category();

      foreach ( $categories as $key=>$category ) {

        // $b = $category->name;
        $b = '<a href="' . get_category_link( $category ) . '">' . $category->name . '</a>';

      }

      $q[$b][] = $count; // Create an array with the category names and post titles

    }
  }
  wp_reset_query();

  array_multisort($count);
  $count = val_sort($page_view_count, 'post_visits_count');
  displayReports($q); ?>

  <!-- <pre><?php //print_r($q); ?></pre> -->


<?php } ?>

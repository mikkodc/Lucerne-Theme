<?php
add_action('wp_dashboard_setup', 'last_visited_widget');

function last_visited_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('visited_data_widget', 'Last 5 Articles Visited', 'last_visited_container');
}

function last_visited_container() {

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

      $pageview = get_post_meta(get_the_ID(), 'post_views_count', true);

      if ($pageview != 0) {
        $page_view_count[] = array(
          'post_title' => get_the_title(),
          'post_view' => $pageview,
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
        </a><span><?php echo " (". $postname['post_view'] . " Views)"; ?></span>
      </li>
    <?php } ?>
  </ul>

  <?php } ?>

<?php
// Our include
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Our variables
$numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 0;
$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;
$category = (isset($_GET['filterCat'])) ? $_GET['filterCat'] : 0;

//Post Arguments
$args = array(
  'post_type' => 'post',
  'posts_per_page' => 6,
  'paged'          => $page,
);

//WP Query
$query2 = new WP_Query($args);

if($query2->have_posts()) { ?>

  <!-- Start Other Articles -->
  <?php while($query2->have_posts()) {

    $query2->the_post();
    $exclude_id = get_the_ID();

    get_template_part( 'template-parts/content-ajax' );

  }
  //Reset Post Data
  wp_reset_postdata();?>

  <!-- End Other Articles -->

<?php }

?>

<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lucerne
 */
get_header(); ?>

  <div id="ajax-container">
    <div class="container-fluid">

      <!-- Start Featured Articles -->
      <?php
        //Post Arguments
        $featured_args = array(
          'post_type' => 'post',
          'posts_per_page' => '3'
        );

        //WP Query
        $the_query = new WP_Query($featured_args);

        if($the_query->have_posts()) {

        //Counter for Large and Small Featured Layout
        $counter = 0; ?>

        <div class="featured-articles clearfix">
          <h2 class="visible-xs section-title">Featured Articles</h2>
          <div class="row">
            <?php while($the_query->have_posts()) {

              $the_query->the_post(); ?>

              <div class="col-md-<?php echo $counter == 0 ? '8 large' : '4 col-xs-6 small' ?>">
                <a class="ajax-link" data-id="<?php echo get_the_ID(); ?>">
                  <img src="<?php the_post_thumbnail_url(); ?>" alt="">
                  <div class="meta-overlay">
                    <h2 class="meta-title"><?php the_title(); ?></h2>
                    <div class="meta-date">
                      <?php the_time('F j, Y'); ?>
                    </div>
                  </div>
                </a>
              </div>

              <?php //Counter Increment
              $counter++;

            } //End While ?>
          </div>
        </div>
      <?php

      //Reset Post Data
      wp_reset_postdata();

      } //End Query ?>
      <!-- End Featured Articles -->
    </div>

    <!-- Start Categories Bar -->
    <div class="container-fluid cat-bar" data-spy="affix" data-offset-top="738">
      <button type="button" class="btn btn-default" id="filter-btn" ></span>Filter <span class="glyphicon glyphicon-triangle-bottom"></button>
        <ul class="pull-left">

          <?php
          //Parent Terms
          $hiterms = get_terms( 'category', array('orderby' => 'name', 'parent' => 0));

      			foreach ( $hiterms as $hiterm ) { ?>
              <li><a href="#" data-term="<?php echo $hiterm->term_id; ?>"><?php echo $hiterm->name; ?></a>

                <?php //Child Terms
                $loterms = get_terms('category', array('orderby' => 'name', 'parent' => $hiterm->term_id));

                  //If has child
                  if($loterms) { ?>

                  <ul>
                  <?php
                    foreach ( $loterms as $loterm ) { ?>
                        <li><a href="#" data-term="<?php echo $loterm->term_id; ?>"><?php echo $loterm->name; ?></a></li>
                    <?php } //End of Child Terms ?>
                  </ul>

                  <?php } //End if has Child Terms ?>
              </li>
      			<?php } //End of Parent Terms ?>
        </ul>
        <div class="pull-right hidden-xs">
          <?php get_search_form(); ?>
        </div>
    </div>
    <!-- End Categories Bar -->

    <div class="container-fluid preload-container">

      <!-- Start Preloader -->
      <div id="preloader" class="clearfix">
        <div class="center-content">
          <img src="<?php echo bloginfo('template_directory'); ?>/library/src/img/ajax-loader.gif" alt="Loading">
        </div>
      </div>
      <!-- End Preloader -->

      <div class="other-articles content-pad clearfix row"></div>
      <span class="load-more">Load More</span>
      <!-- <div id="preload-gif">
        <img src="<?php echo bloginfo('template_directory'); ?>/library/src/img/ajax-loader.gif" alt="Loading">
      </div> -->
    </div><!-- End Preloader Container -->
  </div><!-- End Ajax Container -->
  <div id="intro-article"></div>
</div>
<script>
  var templateDir = "<?php bloginfo('template_directory') ?>";
</script>
<?php
get_footer();

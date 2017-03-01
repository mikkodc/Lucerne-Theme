<div class="container">

  <!-- Start Featured Articles -->
  <?php
    //Post Arguments
    $featured_args = array(
      'post_type' => 'post',
      'posts_per_page' => '3',
      'meta_key'		=> 'featured_article',
      'meta_value'	=> '1'
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

          <div class="col-md-<?php echo $counter == 0 ? '8 large' : '4 small' ?>">
            <a href="<?php echo get_permalink($the_query->ID) ?>" data-id="<?php echo get_the_ID(); ?>">
              <img src="<?php the_post_thumbnail_url(); ?>" alt="">
              <div class="meta-overlay">
                <h2 class="meta-title"><?php the_title(); ?></h2>
                <div class="meta-date">
                  <?php
                    $author_name = get_field('author_name', get_the_ID());
                    $article_date = date_create(get_field('article_date', get_the_ID()));
                    if($author_name) {
                      echo $author_name;
                    } else {
                      echo date_format($article_date, 'j F, Y');
                    } ?>
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
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-default" id="filter-btn" ></span>Filter <span class="glyphicon glyphicon-triangle-bottom"></button>
        <ul class="pull-left">

        <?php
        //Parent Terms
        $hiterms = get_terms( 'category', array('orderby' => 'name', 'parent' => 0, 'hide_empty' => 'true', 'exclude' => 1));

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
  </div>
</div>
<!-- End Categories Bar -->

<div class="container preload-container">

  <div class="row">
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
</div>

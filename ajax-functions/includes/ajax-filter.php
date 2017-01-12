<?php

class ajaxFilter {

	public function __construct() {

    //Search
    add_action(
      'wp_ajax_load_search_results',
      array($this, 'load_search_results')
    );
    add_action(
      'wp_ajax_nopriv_load_search_results',
      array($this, 'load_search_results')
    );

    //Category filter
    add_action(
      'wp_ajax_category_filter_function',
      array($this, 'category_filter_function')
    );
    add_action(
      'wp_ajax_nopriv_category_filter_function',
      array($this, 'category_filter_function')
    );
	}

  //Search Form
  public function load_search_results() {
      $query = $_POST['query'];

      $args = array(
          'post_type' => 'post',
          'post_status' => 'publish',
          's' => $query
      );
      $search = new WP_Query( $args );

      ob_start();

      if ( $search->have_posts() ) :
  			while ( $search->have_posts() ) : $search->the_post();
  				get_template_part( 'template-parts/content-ajax' );
  			endwhile;
  		else :
  			get_template_part( 'template-parts/content-none' );
  		endif;

  	$content = ob_get_clean();

  	echo $content;
  	die();

  }

  //Category Filter
  public function category_filter_function(){

  	$filter = $_GET['filter'];

  	// for taxonomies / categories
  	$args_cat = array(
  		// 'taxonomy' => 'test',
  		// 'field' => 'id',
  		'cat' => $filter
  	);

  	$filter_query = new WP_Query( $args_cat );

  	if( $filter_query->have_posts() ) {
  		while( $filter_query->have_posts() ): $filter_query->the_post();
  			get_template_part( 'template-parts/content-ajax' );
  		endwhile;
  		wp_reset_postdata();
  	} else {
  		get_template_part( 'template-parts/content-none' );
  	}

  	die();
  }
}

?>

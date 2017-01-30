<?php
add_action('wp_dashboard_setup', 'last_viewed_widget');

function last_viewed_widget() {
  global $wp_meta_boxes;

  wp_add_dashboard_widget('viewed_data_widget', 'Last 5 Articles Viewed', 'last_viewed_container');
}

function last_viewed_container() {

  // args
  $args = array(
  	'numberposts'	=> 5,
  	'meta_key'		=> 'article_type',
  	'meta_value'	=> '2'
  );

  // query
  $the_query = new WP_Query( $args );
  if( $the_query->have_posts() ){ ?>
  	<ul>
  	<?php while( $the_query->have_posts() ) { $the_query->the_post(); ?>
  		<li>
  			<a href="<?php the_permalink(); ?>">
  				<?php the_title(); ?>
  			</a>
  		</li>
  	<?php } ?>
  	</ul>
  <?php }

   wp_reset_query();
  }
 ?>

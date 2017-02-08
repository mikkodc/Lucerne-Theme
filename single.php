<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lucerne
 */

get_header(); ?>

	<?php
		//Get Article Type
		$article_type = get_field("article_type");

		//Query the post
		$post_id = get_the_ID();
	  $queried_post = get_post($post_id);
	  $current_article = $queried_post->ID;

		while ( have_posts() ) {
			the_post(); ?>
			<div id="ajax-container">
			<div class="linked-article clearfix">
	      <div class="container">
	        <?php setPostVisits($current_article); ?>
	        <div class="col-md-8 large" style="background: url('<?php echo get_the_post_thumbnail_url($current_article); ?>') center no-repeat">
	        </div>
	        <div class="col-md-4 hidden-xs hidden-sm small article-thumb">
	          <h2 class="section-title">
	            Related Articles  <?php echo getPostVisits($current_article); echo getPostViews($current_article); ?>
	          </h2>
	          <?php
	          $args = array(
	            'post_type' => 'post',
	            'posts_per_page' => '2',
	            'post__not_in' => array($current_article),
	          );
	          $query = get_posts($args);
	          foreach($query as $queries) { ?>
	            <?php //echo var_dump($queries); ?>
	            <a href="<?php echo get_permalink($queries->ID); ?>">
	              <img src="<?php echo get_the_post_thumbnail_url($queries->ID); ?>" alt="" class="img-responsive">
	              <div class="meta-overlay">
	                <div class="meta-date">
	                  <?php
	                    $author_name = get_field('author_name', $queries->ID);
	                    if($author_name) {
	                      echo $author_name;
	                    } else {
	                      echo mysql2date('j F, Y', $queries->post_date);
	                    } ?>
	                </div>
	              </div>
	            </a>
	            <h2 class="article-title"><?php echo $queries->post_title; ?></h2>
	          <?php } ?>
	        </div>

	        <div class="clearfix"></div>

	        <div class="content-pad">

	          <!-- Start Main Intro Content -->
	          <?php $article_type = get_field("article_type", $queried_post); ?>
	          <div class="main-intro-content mb-40">
	            <h2 class="section-title"><?php echo $queried_post->post_title ?></h2>

	            <div class="post-meta">
	              <div class="meta-date">
	                <?php echo mysql2date('j F, Y', $queried_post->post_date);?>
	              </div>

	              <!-- Start Post Tags -->
	              <div class="meta-tags">
	                <?php $posttags = get_the_tags($current_article);
	                if ($posttags) { ?>
	                  <ul class="inline-list">
	                  <?php foreach($posttags as $tag) {
	                    echo '<li>' .$tag->name. '</li>';
	                  } ?>
	                  </ul>
	                <?php } ?>
	              </div>
	              <!-- End Post Tags -->

	            </div>

	            <div class="article-options clearfix">
	              <?php
	                if($article_type == 1) { ?>
	                  <a data-id="<?php echo $post_id ?>" href="#<?php //echo get_the_permalink($queried_post); ?>" type="button" class="btn btn-default btn-view-download ajax-link linked-link">View Article</a>
	                <?php } else { ?>
	                  <!-- <?php $file = get_field('article_pdf', $queried_post); ?> -->
	                  <a href="<?php echo $file['url']; ?>" target="_blank" type="button" class="btn btn-default btn-view-download">Download</a>
	                  <!-- Direct Download -->
	                  <!-- <a href="<?php //echo $file['url']; ?>" download="<?php //echo $file['filename']; ?>" type="button" class="btn btn-default">Download</a> -->
	                <?php }

	                $user_inserted = wp_get_current_user();
	                $current_user_id = $user_inserted->ID;

	                $checkifonreadinglist = $wpdb->get_var(
	                  "
	                  SELECT count(id)
	                  FROM wp_reading_list
	                  WHERE user_id = '".$current_user_id. "'
	                    AND post_id = '".$post_id."'
	                  "
	                );
	                ob_start(); ?>
	                <button type="button" class="btn btn-default remove-to-list" data-id="<?php echo $post_id ?>"><span class="glyphicon glyphicon-minus"></span> Reading List</button>
	                <?php $readingButton = ob_get_clean();

	                if($checkifonreadinglist) {
	                  echo $readingButton;
	                } else { ?>
	                  <button type="button" class="btn btn-default add-to-list" data-id="<?php echo $post_id ?>"><span class="glyphicon glyphicon-plus"></span> Reading List</button>
	                <?php } ?>

	            </div>

	            <?php if($article_type == 2){

	              get_template_part('template-parts/template-author'); ?>

	              <div class="clearfix"></div>
	            <?php } ?>

	            <div class="article-excerpt">
	              <?php echo $article_type == 1 ? '<p>' .wp_trim_words( get_field("article_summary", $queried_post), 40, ''). '</p>' : get_field("article_content", $queried_post); ?>
	            </div>
	          </div>
	          <!-- End Main Intro Content -->

	          <?php if ($article_type != 2) {
	            get_template_part('template-parts/template-author');
	          } ?>

	          <!-- Start Related Author Posts -->
	          <div class="author-related">
	            <?php
	            $staff_fullname = $post_object->post_title;
	            $staff_first_explode = explode(' ',trim($staff_fullname));

	            if ($post_object) {
	              $args = array(
	                'post_type' => 'post',
	                'posts_per_page' => '3',
	                'post__not_in' => array($current_article),
	                'meta_key'		=> 'assign_staff_member',
	                'meta_value'	=> $post_object->ID
	              );
	            } else {
	              $args = array(
	                'post_type' => 'post',
	                'posts_per_page' => '3',
	                'post__not_in' => array($current_article),
	                'author' => $queried_post->post_author,
	              );
	            }

	            $articleQuery = get_posts($args);

	            if($articleQuery != NULL) { ?>

	            <h3 class="section-title">More from <?php echo $post_object ? $staff_first_explode[0] : the_author_meta('user_firstname', $queried_post->post_author); ?></h3>
	            <div class="row">
	              <?php foreach($articleQuery as $artQueries) { ?>
	                <div class="col-sm-6 col-md-4 article-item">
	                  <a href="<?php echo get_permalink($artQueries->ID); ?>">
	                    <img src="<?php echo get_the_post_thumbnail_url($artQueries->ID, 'article-thumb'); ?>" alt="" class="img-responsive">
	                    <div class="meta-overlay">
	                      <div class="meta-date">
	                        <?php
	                          $author_name = get_field('author_name', $artQueries->ID);
	                          if($author_name) {
	                            echo $author_name;
	                          } else {
	                            echo mysql2date('j F, Y', $artQueries->post_date);
	                          } ?>
	                      </div>
	                    </div>
	                  </a>
	                  <h4 class="article-title"><a href="<?php echo get_permalink($artQueries->ID); ?>"><?php echo $artQueries->post_title; ?></a></h4>
	                </div>
	              <?php }
	            ?>
	            </div>
	          </div>
	          <!-- End Related Author Posts -->
	          <?php } ?>

	          <div class="visible-xs visible-sm small article-thumb">
	            <h2 class="section-title">
	              Related Articles <?php echo getPostVisits($current_article); echo getPostViews($current_article); ?>
	            </h2>
	            <div class="row">
	            <?php
	            $args = array(
	              'post_type' => 'post',
	              'posts_per_page' => '2',
	              'post__not_in' => array($current_article),

	            );
	            $query = get_posts($args);
	            foreach($query as $queries) { ?>
	              <?php //echo var_dump($queries); ?>
	              <div class="col-sm-6">
	                <a href="<?php get_permalink($queries->ID); ?>">
	                <img src="<?php echo get_the_post_thumbnail_url($queries->ID); ?>" alt="" class="img-responsive">
	                <div class="meta-overlay">
	                  <div class="meta-date">
	                    <?php echo mysql2date('j F, Y', $queries->post_date); ?>
	                  </div>
	                </div>
	                </a>
	                <h2 class="article-title"><?php echo $queries->post_title; ?></h2>
	              </div>
	            <?php } ?>
	            </div>
	          </div>

	        </div><!-- End Content Pad -->
	      </div> <!-- End Container -->
	    </div> <!-- End Linked Article -->
		</div>

		<?php }

//get_sidebar();
get_footer(); ?>
<script>
  var templateDir = "<?php bloginfo('template_directory') ?>";
</script>

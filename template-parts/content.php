<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lucerne
 */

?>
<?php $current_article = get_the_ID(); ?>
<div class="linked-article clearfix">
  <div class="col-md-8 large" style="background: url('<?php echo get_the_post_thumbnail_url(); ?>') center no-repeat">
  </div>
  <div class="col-md-4 small article-thumb">
    <h2 class="section-title">
      Related Articles
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
            <?php echo mysql2date('j F, Y', $queries->post_date); ?>
          </div>
        </div>
      </a>
      <h2 class="article-title"><?php echo $queries->post_title; ?></h2>
    <?php } ?>
  </div>

  <div class="clearfix"></div>

  <div class="container-fluid">

    <div class="content-pad">

      <!-- Start Main Intro Content -->
      <div class="main-intro-content mb-40">
        <h2 class="section-title"><?php the_title() ?></h2>

        <div class="post-meta">
          <div class="meta-date">
            <?php echo mysql2date('j F, Y', the_date());?>
          </div>
          <div class="meta-tags">
            <?php echo get_the_tag_list('<ul class="inline-list"><li>', '</li><li>','
            </li></ul>', $current_article); ?>
          </div>
        </div>

        <p class="article-excerpt"><?php echo wp_trim_words( the_content(), 40, ''); ?></p>

        <div class="article-options">
          <a href="" type="button" class="btn btn-default">Download</a>
          <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Reading List</button>
        </div>
      </div>
      <!-- End Main Intro Content -->

      <!-- Start Author Meta -->
      <div class="author-meta row mb-40">
        <div class="author-foreword col-md-7">
          <?php the_author_meta('description'); ?>
        </div>
        <div class="author-info col-md-5">
          <div class="row">
            <div class="col-md-4">
              <?php
								$args = array(
									'default' => 'wavatar',
									'class' => array('img-responsive')
								);
								echo get_avatar( get_the_author_meta( 'ID' ) , 250, $args );
							?>
            </div>
            <div class="col-md-8">
              <div class="section-title">
                <?php echo the_author_meta('user_firstname'); ?>
                <?php echo the_author_meta('user_lastname'); ?>
              </div>
              <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo the_author_meta('user_email'); ?>">Email [<?php echo the_author_meta('user_firstname'); ?>]</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Author Meta -->

      <!-- Start Related Author Posts -->
      <div class="author-related">
        <h3 class="section-title">More from <?php echo the_author_meta('user_firstname'); ?></h3>
        <div class="row">
        <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page' => '3',
            'post__not_in' => array($current_article),
            'author' => get_the_author_meta('ID')
          );
          $articleQuery = get_posts($args);
          foreach($articleQuery as $artQueries) { ?>
            <?php //echo var_dump($artQueries); ?>
            <div class="col-md-4 article-item">
              <a href="<?php echo get_permalink($artQueries->ID); ?>">
                <img src="<?php echo get_the_post_thumbnail_url($artQueries->ID, 'article-thumb'); ?>" alt="" class="img-responsive">
                <div class="meta-overlay">
                  <div class="meta-date">
                    <?php echo mysql2date('j F, Y', $artQueries->post_date); ?>
                  </div>
                </div>
              </a>
              <h4 class="article-title"><?php echo $artQueries->post_title; ?></h4>
            </div>
          <?php }
        ?>
        </div>
      </div>
      <!-- End Related Author Posts -->

    </div><!-- End Content Pad -->
  </div> <!-- End Container -->
</div> <!-- End Linked Article -->

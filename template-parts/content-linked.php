<?php
//Get post ID from Ajax
$post_id = $_GET['article'];
$type = $_GET['articleType'];

if($post_id == 0) {
  get_template_part( 'template-parts/content-front' );
} else {

  //Query the post
  $queried_post = get_post($post_id);
  $current_article = $queried_post->ID;

  if($type == "linked") { ?>
    <iframe src="<?php the_field("article_link", $current_article) ?>" class="linked-frame"></iframe>

  <?php } else { ?>
    <div class="linked-article clearfix">
      <div class="container">
        <div class="col-md-8 large" style="background: url('<?php echo get_the_post_thumbnail_url($current_article); ?>') center no-repeat">
        </div>
        <div class="col-md-4 hidden-xs hidden-sm small article-thumb">
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
            <a class="ajax-link" data-id="<?php echo $queries->ID; ?>">
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
                  <a href="#<?php //echo get_the_permalink($queried_post); ?>" type="button" class="btn btn-default ajax-link linked-link">View Article</a>
                <?php } else { ?>
                  <?php $file = get_field('article_pdf', $queried_post); ?>
                  <a href="<?php echo $file['url']; ?>" target="_blank" type="button" class="btn btn-default">Download</a>
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

            <?php if($article_type == 2){ ?>
              <!-- Start Author Meta -->
              <div class="author-meta row mb-20">

                <div class="author-info col-md-6">
                  <div class="row">

                    <!-- Start Author Image -->
                    <div class="col-xs-5 col-md-4">
                      <?php
                      $author_id = get_the_author_meta('ID');
                      $staff_avatar = get_field('staff_image', 'user_'. $queried_post->post_author);
                      $size = 'full';
                      //echo wp_get_attachment_image_url( $staff_avatar, $size );?>
                      <img src="<?php echo $staff_avatar['url']; ?>" alt="<?php echo $staff_avatar['alt']; ?>" class="img-responsive">
                    </div>
                    <!-- End Author Image -->

                    <!-- Start Author Details -->
                    <div class="col-xs-7 col-md-8">
                      <h3 class="author-name"><?php echo the_author_meta('user_firstname', $queried_post->post_author); ?>
                        <?php echo the_author_meta('user_lastname', $queried_post->post_author); ?></h3>
                      <h3 class="author-title"><?php the_field('staff_title', 'user_'. $queried_post->post_author) ?></h3>
                      <ul class="no-bullet">
                        <li>
                          <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo the_author_meta('user_email', $queried_post->post_author); ?>">Email <?php echo the_author_meta('user_firstname', $queried_post->post_author); ?></a>
                        </li>
                        <li>
                          <span class="glyphicon glyphicon-phone"></span> <a href="tel:<?php echo the_author_meta('phone', $queried_post->post_author); ?>"> <?php echo the_author_meta('phone', $queried_post->post_author); ?></a>
                        </li>
                      </ul>
                    </div>
                    <!-- End Author Details -->

                  </div>
                </div>
                <blockquote class="author-foreword col-md-6">
                  <?php the_field("staff_member_foreword", $queried_post); ?>
                </blockquote>
              </div>
              <!-- End Author Meta -->
              <div class="clearfix"></div>
            <?php } ?>



            <div class="article-excerpt">
              <?php echo $article_type == 1 ? '<p>' .wp_trim_words( get_field("article_summary", $queried_post), 40, ''). '</p>' : get_field("article_content", $queried_post); ?>
            </div>
          </div>
          <!-- End Main Intro Content -->

          <?php if ($article_type != 2) { ?>
          <!-- Start Author Meta -->
          <div class="author-meta row mb-20">

            <div class="author-info col-md-6">
              <div class="row">

                <!-- Start Author Image -->
                <div class="col-xs-5 col-md-4">
                  <?php
                  $author_id = get_the_author_meta('ID');
                  $staff_avatar = get_field('staff_image', 'user_'. $queried_post->post_author);
                  $size = 'full';
                  // echo wp_get_attachment_image_url( $staff_avatar, $size );?>
                  <img src="<?php echo $staff_avatar['url']; ?>" alt="<?php echo $staff_avatar['alt']; ?>" class="img-responsive">
                </div>
                <!-- End Author Image -->

                <!-- Start Author Details -->
                <div class="col-xs-7 col-md-8">
                  <h3 class="author-name"><?php echo the_author_meta('user_firstname', $queried_post->post_author); ?>
                    <?php echo the_author_meta('user_lastname', $queried_post->post_author); ?></h3>
                  <h3 class="author-title"><?php the_field('staff_title', 'user_'. $queried_post->post_author) ?></h3>
                  <ul class="no-bullet">
                    <li>
                      <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo the_author_meta('user_email', $queried_post->post_author); ?>">Email <?php echo the_author_meta('user_firstname', $queried_post->post_author); ?></a>
                    </li>
                    <li>
                      <span class="glyphicon glyphicon-phone"></span> <a href="tel:<?php echo the_author_meta('phone', $queried_post->post_author); ?>"> <?php echo the_author_meta('phone', $queried_post->post_author); ?></a>
                    </li>
                  </ul>
                </div>
                <!-- End Author Details -->

              </div>
            </div>
            <blockquote class="author-foreword col-md-6">
              <?php the_field("staff_member_foreword", $queried_post); ?>
            </blockquote>
          </div>
          <!-- End Author Meta -->
          <?php } ?>

          <!-- Start Related Author Posts -->
          <div class="author-related">
            <h3 class="section-title">More from <?php echo the_author_meta('user_firstname', $queried_post->post_author); ?></h3>
            <div class="row">
            <?php
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => '3',
                'post__not_in' => array($current_article),
                'author' => $queried_post->post_author,
              );
              $articleQuery = get_posts($args);
              foreach($articleQuery as $artQueries) { ?>
                <div class="col-sm-6 col-md-4 article-item">
                  <a class="ajax-link" data-id="<?php echo $artQueries->ID ?>">
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
                  <h4 class="article-title"><a class="ajax-link" data-id="<?php echo $artQueries->ID ?>"><?php echo $artQueries->post_title; ?></a></h4>
                </div>
              <?php }
            ?>
            </div>
          </div>
          <!-- End Related Author Posts -->

          <div class="visible-xs visible-sm small article-thumb">
            <h2 class="section-title">
              Related Articles
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
                <a class="ajax-link" data-id="<?php echo $queries->ID; ?>">
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
  <?php }
  die();
} ?>

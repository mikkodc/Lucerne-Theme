<div class="col-md-4 col-sm-6 article-item">
  <a class="ajax-link" data-id="<?php echo get_the_ID(); ?>">
    <img src="<?php the_post_thumbnail_url('article-thumb'); ?>" alt="">
    <div class="meta-overlay">
      <div class="meta-date">
        <?php the_time('F j, Y'); ?>
      </div>
    </div>
  </a>
  <h3 class="article-title"><a class="ajax-link" data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></a></h3>
  <p class="article-excerpt">
      <?php $article_type = get_field("article_type", $queried_post); ?>
      <?php //echo $article_type == 1 ? '<p>' .wp_trim_words( get_field("article_summary", $queried_post), 40, ''). '</p>' : wp_trim_words( get_field("article_content", $queried_post), 40, ''); ?>
      <?php echo wp_trim_words( get_field("article_content", $queried_post), 40, ''); ?>
      <?php echo wp_trim_words( get_field("article_summary", $queried_post), 40, '') ?>


  </p>
</div>

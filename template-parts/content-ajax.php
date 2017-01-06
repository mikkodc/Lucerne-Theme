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
  <p class="article-excerpt"><?php echo wp_trim_words( get_the_content(), 40, ''); ?></p>
</div>

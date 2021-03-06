<div class="col-md-4 col-sm-6 article-item">
  <a href="<?php the_permalink(); ?>">
    <img src="<?php the_post_thumbnail_url('article-thumb'); ?>" alt="<?php the_title(); ?>">
    <div class="meta-overlay">
      <div class="meta-date">
        <?php
          $author_name = get_field('author_name', get_the_ID());
          $article_date = date_create(get_field('article_date', get_the_ID()));
          if($author_name) {
            echo $author_name;
          } else {
            $article_date = date_create(get_field('article_date', get_the_ID()));
            echo date_format($article_date, 'j F, Y');
          }
          ?>
      </div>
    </div>
  </a>
  <h3 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  <p class="article-excerpt">
      <?php $article_type = get_field("article_type", $queried_post); ?>
      <?php //echo $article_type == 1 ? '<p>' .wp_trim_words( get_field("article_summary", $queried_post), 40, ''). '</p>' : wp_trim_words( get_field("article_content", $queried_post), 40, ''); ?>
      <?php echo wp_trim_words( get_field("article_content", $queried_post), 40, ''); ?>
      <?php echo wp_trim_words( get_field("article_summary", $queried_post), 40, '') ?>
  </p>
</div>

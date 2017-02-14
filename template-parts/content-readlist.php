<?php
//Get post ID from Ajax
$post_id = $_GET['article'];
$articleQuery = get_post($post_id);
?>
<div class="item-container clearfix" data-id="<?php echo $articleQuery->ID ?>">
  <div class="col-xs-10 article-item">
    <a class="ajax-link" data-id="<?php echo $articleQuery->ID ?>">
      <img src="<?php echo get_the_post_thumbnail_url($articleQuery->ID, 'article-thumb'); ?>" alt="" class="img-responsive">
      <div class="meta-overlay">
        <div class="meta-date">
          <?php
            $author_name = get_field('author_name', $articleQuery->ID);
            if($author_name) {
              echo $author_name;
            } else {
              echo mysql2date('j F, Y', $articleQuery->post_date);
            } ?>
        </div>
      </div>
    </a>
    <h4 class="article-title"><a class="ajax-link" data-id="<?php echo $articleQuery->ID ?>"><?php echo $articleQuery->post_title; ?></a></h4>
  </div>
  <div class="col-xs-2 remove-item">
    <a href="#" data-id="<?php echo $articleQuery->ID ?>" class="remove-to-list"><span class="glyphicon glyphicon-remove"></span></a>
  </div>
</div>

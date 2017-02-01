<?php
$post_id = $_GET['article'];
$queried_post = get_post($post_id);

$post_object = get_field('assign_staff_member', $queried_post); ?>

<!-- Start Author Meta -->
<div class="author-meta row mb-20">
  <?php if( $post_object ) { ?>
  <div class="author-info col-md-6">
    <div class="row">

      <!-- Start Author Image -->
      <div class="col-xs-5 col-md-4">
        <?php
        $staff_id = $post_object->ID;
        $staff_name = $post_object->post_title;
        $staff_avatar = get_field('staff_image', $staff_id);
        $staff_email = get_field('staff_email', $staff_id);
        $staff_phone = get_field('staff_phone', $staff_id);

        // vars
        $url = $staff_avatar['url'];
        $title = $staff_avatar['title'];
        $alt = $staff_avatar['alt'];
        $caption = $staff_avatar['caption'];

        // thumbnail
        $size = 'thumbnail';
        $thumb = $staff_avatar['sizes'][ $size ];
        $width = $staff_avatar['sizes'][ $size . '-width' ];
        $height = $staff_avatar['sizes'][ $size . '-height' ]; ?>

        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="img-responsive">
      </div>
      <!-- End Author Image -->

      <!-- Start Author Details -->
      <div class="col-xs-7 col-md-8">
        <h3 class="author-name"><?php echo $staff_name ?></h3>
        <h3 class="author-title"><?php the_field('staff_title', $staff_id) ?></h3>
        <ul class="no-bullet">
          <?php if ($staff_email != "") { ?>
            <li>
              <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo $staff_email ?>">Email <?php echo the_field('staff_first_name', $staff_id); ?></a>
            </li>
          <?php } ?>
          <?php if ($staff_phone != "") { ?>
          <li>
            <span class="glyphicon glyphicon-phone"></span> <a href="tel:<?php echo $staff_phone ?>"> <?php echo $staff_phone ?></a>
          </li>
          <?php } ?>
        </ul>
      </div>
      <!-- End Author Details -->

    </div>
  </div>
  <?php } else { ?>
  <div class="author-info col-md-6">
    <div class="row">

      <!-- Start Author Image -->
      <div class="col-xs-5 col-md-4">
        <?php $author_id = get_the_author_meta('ID');
        $staff_avatar = get_field('staff_image', 'user_'. $queried_post->post_author);

        // vars
        $url = $staff_avatar['url'];
        $title = $staff_avatar['title'];
        $alt = $staff_avatar['alt'];
        $caption = $staff_avatar['caption'];

        // thumbnail
        $size = 'thumbnail';
        $thumb = $staff_avatar['sizes'][ $size ];
        $width = $staff_avatar['sizes'][ $size . '-width' ];
        $height = $staff_avatar['sizes'][ $size . '-height' ]; ?>

        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="img-responsive">
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
  <?php } ?>
  <blockquote class="author-foreword col-md-6">
    <?php the_field("staff_member_foreword", $queried_post); ?>
  </blockquote>
</div>
<!-- End Author Meta -->
